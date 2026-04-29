<?php

namespace App\Http\Controllers;

use App\Models\Interaction;
use App\Models\Project;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;

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

        Interaction::create($info);

        if($request->interactiontype==1){// Interacción final
            Log::debug("InteractionController / Destruyendo la sesión...");
            Session::regenerate();
            Log::debug("InteractionController / Sesión destruida");
        }

        Log::debug("InteractionController / registerInteraction / 2");

        $mensaje   = 'Interacción registrada correctamente';
        return response()->json(['success'=>'Y', 'message'=>$mensaje]);

    }

}
