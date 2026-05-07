<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerProjects;
use App\Models\Interaction;
use App\Models\Project;
use App\Services\WebhookDispatcher;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Arr;

use App\Http\Controllers\Mobile_Detect;

class InteractionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request){
        //
    }




    public function registerInteraction(Request $request){

        Log::debug("InteractionController / registerInteraction / 1");
        Log::debug("----------------------------------------------");
        Log::debug(json_encode($request));

        $request->project=openssl_decrypt ($request->project, $ciphering="AES-128-CTR",
        $decryption_key="PlayFunnel", $options=0, $decryption_iv="1234567891011121");

        if (! $request->project){
            return 'Error: Proyecto no encontrado';
        }

        $device   = DashboardController::get_client_device();
        $ip       = DashboardController::get_ip();

        // Si estamos trabajando en local, se pone la IP por defecto "2.153.129.0" ubicada en Madrid
        Log::debug("ip original identificada:     ".$ip);
        if($ip=="127.0.0.1" or $ip=="::1"){
            $ip = "2.153.129.0";
        }
        Log::debug($request);
        Log::debug("ip tras cambio por ip válida: ".$ip);

        $location = DashboardController::get_ip_info($ip, "Location");

        //$info = ['sessionid'=> session()->getId(),'projectid'=>$request->project,  //<- Test by session but is diferent in real test
        $info = ['sessionid'=>$request->_token,'projectid'=>$request->project,   //<- Test by session funciona pero repite el token en local
                'loc_ip'            =>$ip,
                'loc_city'          =>$location['city'],
                'loc_state'         =>$location['state'],
                'loc_country'       =>$location['country'],
                'loc_country_code'  =>$location['country_code'],
                'loc_continent'     =>$location['continent'],
                'loc_continent_code'=>$location['continent_code'],
                'device'            =>$device,
                'cuepointid'        =>$request->cuepointid,
                'cuepointname'      =>$request->cuepointname,
                'cuepointoptionid'  =>$request->cuepointoptionid,
                'cuepointoptionname'=>$request->cuepointoptionname,
                'interactiontype'    =>$request->interactiontype
                ];

        if (Schema::hasColumn('interaction', 'cuepointtag')) {
            $info['cuepointtag'] = $request->cuepointtag;
        }

        $interaction = Interaction::create($info);
        $this->syncInteractionTagToCustomer($request);

        $project = Project::find($request->project);
        $payload = [
            'interaction' => $interaction->toArray(),
            'session_id' => $request->_token,
            'cuepoint' => [
                'id' => $request->cuepointid,
                'name' => $request->cuepointname,
                'option_id' => $request->cuepointoptionid,
                'option_name' => $request->cuepointoptionname,
                'tag' => $request->cuepointtag,
            ],
            'location' => [
                'ip' => $ip,
                'city' => $location['city'],
                'state' => $location['state'],
                'country' => $location['country'],
                'country_code' => $location['country_code'],
                'continent' => $location['continent'],
                'continent_code' => $location['continent_code'],
            ],
            'device' => $device,
        ];

        app(WebhookDispatcher::class)->dispatch('interaction.created', $project, $payload);

        if($request->cuepointtag){
            app(WebhookDispatcher::class)->dispatch('tag.assigned', $project, $payload);
        }

        if($request->interactiontype==1){// Interacción final
            app(WebhookDispatcher::class)->dispatch('funnel.completed', $project, $payload);
            Log::debug("InteractionController / Destruyendo la sesión...");
            Session::regenerate();
            Log::debug("InteractionController / Sesión destruida");
        }

        Log::debug("InteractionController / registerInteraction / 2");

        $mensaje   = 'Interacción registrada correctamente';
        return response()->json(['success'=>'Y', 'message'=>$mensaje]);

    }

    protected function syncInteractionTagToCustomer(Request $request)
    {
        $tagName = trim((string) $request->cuepointtag);
        if ($tagName === '' || !Schema::hasColumn('crm', 'tags')) {
            return;
        }

        $customerId = CustomerProjects::where('projectId', intval($request->project))
            ->where('sessionId', $request->_token)
            ->orderBy('id', 'desc')
            ->value('customerId');

        if (!$customerId) {
            return;
        }

        $customer = Customer::find($customerId);
        if (!$customer) {
            return;
        }

        $currentTags = collect(explode(',', (string) ($customer->tags ?? '')))
            ->map(function ($tag) {
                return trim((string) $tag);
            })
            ->filter(function ($tag) {
                return $tag !== '';
            })
            ->values();

        if (!$currentTags->contains($tagName)) {
            $currentTags->push($tagName);
        }

        $customer->tags = $currentTags->implode(', ');
        $customer->save();
    }

}
