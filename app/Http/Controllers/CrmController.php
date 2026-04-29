<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use App\Models\CustomerProjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Interaction;
use App\Models\Project;
use App\Models\User;
use App\Models\UserConfig;

class CrmController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }


    public function index(Request $request){


            //SEARCH PROJECTS BY USER
            $user = User::find(Auth::id());
            $projects = Project::where('user_id', Auth::id())->get();

            $prject_ids = array();
            foreach($projects as $project){
                $prject_ids[] = $project->id;
            }
            Log::info('PROJECTS BY USER:');
            Log::info($prject_ids);


           //SEARCH CUSTOMERS IN CustomersProjects
           $customersIds = CustomerProjects::whereIn('projectId', $prject_ids)
           ->groupBy('customerId')
           ->pluck('customerId');
           Log::info('CUSTOMERS ID:');
           Log::info($customersIds );
           Log::info('step 1');


            //GET CUSTOMERS
            Log::info('step 2');
            $customers = Customer::whereIn('id', $customersIds)->get();
            Log::info(json_encode($customers));
            Log::info('step 3');

            return view('crm', compact('projects','customers'));






    }


    //*****************|| GETS ||****************************/
    //*******************************************************/

    //Get Customer By Email
    function getCustomerIdByEmail($email){
        try {
            $cliente = Customer::select()
            ->where('email',$email )
            ->first();
        } catch (\Throwable $th) {
            Log::info('customerData NO FOUND: '. $th->getMessage());
        }
        return $cliente->id;
    }


    //Get Customers By ProjectId
    public function getCustomersByProject(Request $request){
        Log::info('_________________ getCustomersByProject ___________________________');
        Log::info($request);

        $projectId = intval($request->projectId);
        Log::info( intval($projectId));

           //SEARCH CUSTOMERS IN CustomersProjects
           $customersIds = CustomerProjects::where('projectId',$projectId)
           ->groupBy('customerId')
           ->pluck('customerId');
           Log::info('CUSTOMERS ID:');
           Log::info($customersIds );


            //GET CUSTOMERS
            $customers = Customer::whereIn('id', $customersIds)->get();
            Log::info(json_encode($customers));

            return response()->json(['success'=>'Y','customers'=>$customers]);
    }

    //Get Customer By Id
    public function getCutomerById(Request $request){
        Log::info('_________________ getCutomerById v1 ___________________________');
        Log::info($request);

        //Get Client
        try {
            $cliente = Customer::select()
            ->where('id',$request->CustomerId )
            ->first();
        } catch (\Throwable $th) {
            Log::info('customerData NO FOUND: '. $th->getMessage());
        }

        //Get sessions Array
        $SessionsIds = CustomerProjects::where('CustomerId',$request->CustomerId)
        ->groupBy('sessionId')
        ->pluck('sessionId');
        Log::info('Session ID:');
        Log::info($SessionsIds);


         //Get Interactions Array
         $interactions = Interaction::select(
            'sessionid','projectid',
            DB::raw('GROUP_CONCAT(coalesce(cuepointoptionname,\'NULO\')SEPARATOR \' | \') as cuepointoptionname'),
            DB::raw('case when MAX(interactiontype)=0 then \'Interacción\' when  MAX(interactiontype)=1 then \'Completa\' else \'Otra\' end as actividad'),
            DB::raw('MIN(created_at) AS created_at'),
            DB::raw('MAX(loc_country_code) AS loc_country_code'),
            )
            ->whereIn('sessionid', $SessionsIds )
            ->groupBy('sessionid')
            ->groupBy('projectid')
            ->orderBy('created_at','desc');
            Log::info('Interations ID:');
            Log::info($interactions->get());
            $interactions = $interactions->get();


        //Get Name Project
        foreach($interactions as $int){
             //SEARCH CUSTOMERS IN CustomersProjects
           $projectName = Project::select('name')
           ->where('id', $int->projectid)
           ->pluck('name');

           $int->nameProject = $projectName;
           Log::info('NAME OF PROJECT:');
           Log::info($projectName);
        }
        Log::info($interactions);


        return response()->json(['success'=>'Y','customers'=>$cliente,'iteractions'=>$interactions]);
    }


    //*****************|| POST ||****************************/
    //*******************************************************/

    //Post Customer from Embed
    public function crmregister(Request $request){
        //Log::info('*********************************************************************');
        //Log::info('REQUEST-----------------------------------------');
        //Log::info($request);
        //Log::info('DATA NAME: -----------------------------------------'.' '.$request['f-name']);
        //Log::info('Token_: '.$request['_token']);
        //Log::info('POJECT_ID: '.$request['projectid']);
        //Log::info('EMAIL: '.$request['f-email']);

        //CREATE VARS TO USE LIKE ARRAY
        $interactions = null;
        $projects = null;
        $customerData = null;

        //SEARCH CUSTOMER
        try {
            $cliente = Customer::select()
            ->where('email', $request['f-email'] )
            ->first();
            //Log::info($cliente->email);
            //Log::info($customerData);
        } catch (\Throwable $th) {
            Log::info('customerData NO FOUND: '. $th->getMessage());
        }

        //IF EMAIL EXIST
        if(isset($cliente)){
             //->PROJECTS & INTERACTIONS
             $project = $request['projectid'];
             $projects = explode (",", $cliente->projects);
             $interaction = $request['_token'];
             //$interactions = explode (",", $cliente->interactions);

             //Log::info('SAME EMAIL');
             foreach ($cliente->getAttributes() as $key => $value) {
                    //IF IS SET AND NOT NULL WITH 'F-'= NAME FROM FORM
                if(isset($request['f-'.$key]) && $request['f-'.$key] != NULL){
                        //Log::info('f-'.$key.' : '. $request['f-'.$key]);
                        //UPDATE ATTRIBUTE IF DIFFERENT FROM THE ORIGINAL VALUE
                        if($request['f-'.$key] != $value){
                            $cliente->$key = $request['f-'.$key];
                        }
                }
             }
             $cliente->save();
             $customerId = $this->getCustomerIdByEmail($request['f-email']);
             //Log::info('CLIENTE ID CAPTURE: '.$customerId);

             //Create row in customerProjects Table
             $this->customerProjectCreate($customerId, $request['projectid'], $request['_token']);
        }
        //ELSE NO EMAIL IN BD
        else{
            //Log::info('CRM CASE NO USER REGISTER');
            $customer = [
                'name' => $request['f-name'],
                'email'=>$request['f-email'] ,
                'phone_number'=>$request['f-tel'] ,
                'address'=>$request['f-address'],
                'birthday'=>$request['f-birthday'],
                'city'=>$request['f-city'],
                'state'=>$request['f-state'],
                'cp'=>$request['f-cp'],
                'country'=>$request['f-country'],
            ];
            Customer::create($customer);


            $customerId = $this->getCustomerIdByEmail($request['f-email']);
            //Log::info('CLIENTE ID CAPTURE: '.$customerId);

            //Create row in customerProjects Table
            $this->customerProjectCreate($customerId, $request['projectid'], $request['_token']);


        }
    }

    //Post Customer & Project Relationship
    function customerProjectCreate($customerId, $projectId, $session){

        if($customerId != null  && $projectId != null &&  $session != null){
          //UPDATE CUSTOMERS_PROJECTS - no model
          DB::table('customers_projects')->insert([
                'customerId' => $customerId,
                'projectId' => $projectId,
                'sessionId' => $session,
           ]);
        }
    }




}
