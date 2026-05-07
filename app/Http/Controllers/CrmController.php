<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CrmCustomField;
use App\Models\CrmCustomFieldValue;
use App\Models\CrmTag;
use App\Models\Customer;
use App\Models\CustomerProjects;
use App\Models\Interaction;
use App\Models\Project;
use App\Models\User;
use App\Models\UserConfig;
use App\Services\WebhookDispatcher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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


            $crmCustomFields = CrmCustomField::where('userid', Auth::id())
                ->orderBy('name', 'asc')
                ->get();
            $crmTags = collect();
            if (Schema::hasTable('crm_tags')) {
                $crmTags = CrmTag::where('userid', Auth::id())
                    ->orderBy('name', 'asc')
                    ->get();
            }
            $crmColumnDefinitions = $this->getCrmColumnDefinitions($crmCustomFields);
            $crmVisibleColumns = $this->getVisibleCrmColumns($crmColumnDefinitions);

            //GET CUSTOMERS
            Log::info('step 2');
            $customers = Customer::whereIn('id', $customersIds)
                ->with(['customFieldValues' => function ($query) use ($crmCustomFields) {
                    if ($crmCustomFields->count()) {
                        $query->whereIn('crm_custom_field_id', $crmCustomFields->pluck('id')->all());
                    }
                }])
                ->get();
            $crmTableRows = $this->buildCrmTableRows($customers, $crmCustomFields);
            Log::info(json_encode($customers));
            Log::info('step 3');

            return view('crm', compact('projects','customers', 'crmCustomFields', 'crmTags', 'crmColumnDefinitions', 'crmVisibleColumns', 'crmTableRows'));






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

        $projectAllowed = Project::where('id', $projectId)
            ->where('user_id', Auth::id())
            ->exists();

        if(!$projectAllowed){
            return response()->json([
                'success' => 'N',
                'message' => 'No tiene permisos para ver este proyecto',
            ]);
        }

           //SEARCH CUSTOMERS IN CustomersProjects
           $customersIds = CustomerProjects::where('projectId',$projectId)
           ->groupBy('customerId')
           ->pluck('customerId');
           Log::info('CUSTOMERS ID:');
           Log::info($customersIds );


            $crmCustomFields = CrmCustomField::where('userid', Auth::id())
                ->orderBy('name', 'asc')
                ->get();

            //GET CUSTOMERS
            $customers = Customer::whereIn('id', $customersIds)
                ->with(['customFieldValues' => function ($query) use ($crmCustomFields) {
                    if ($crmCustomFields->count()) {
                        $query->whereIn('crm_custom_field_id', $crmCustomFields->pluck('id')->all());
                    }
                }])
                ->get();
            Log::info(json_encode($customers));

            return response()->json([
                'success' => 'Y',
                'customers' => $this->buildCrmTableRows($customers, $crmCustomFields),
            ]);
    }

    //Get Customer By Id
    public function getCutomerById(Request $request){
        Log::info('_________________ getCutomerById v1 ___________________________');
        Log::info($request);

        $customerId = intval($request->CustomerId);
        if($customerId <= 0){
            return response()->json([
                'success' => 'N',
                'message' => 'ID de cliente inválido',
            ]);
        }

        $allowedProjectIds = Project::where('user_id', Auth::id())->pluck('id');
        $hasPermission = CustomerProjects::where('customerId', $customerId)
            ->whereIn('projectId', $allowedProjectIds)
            ->exists();

        if(!$hasPermission){
            return response()->json([
                'success' => 'N',
                'message' => 'No tiene permisos para ver este cliente',
            ]);
        }

        //Get Client
        try {
            $cliente = Customer::select()
            ->where('id',$customerId )
            ->first();
        } catch (\Throwable $th) {
            Log::info('customerData NO FOUND: '. $th->getMessage());
        }

        if(!isset($cliente) || !$cliente){
            return response()->json([
                'success' => 'N',
                'message' => 'Cliente no encontrado',
            ]);
        }

        //Get sessions Array
        $SessionsIds = CustomerProjects::where('CustomerId',$customerId)
        ->whereIn('projectId', $allowedProjectIds)
        ->groupBy('sessionId')
        ->pluck('sessionId');
        Log::info('Session ID:');
        Log::info($SessionsIds);


         //Get Interactions Array
         $interactionSelect = [
            'sessionid',
            'projectid',
            DB::raw('GROUP_CONCAT(coalesce(cuepointoptionname,\'NULO\')SEPARATOR \' | \') as cuepointoptionname'),
            DB::raw('case when MAX(interactiontype)=0 then \'Interacción\' when  MAX(interactiontype)=1 then \'Completa\' else \'Otra\' end as actividad'),
            DB::raw('MIN(created_at) AS created_at'),
            DB::raw('MAX(loc_country_code) AS loc_country_code'),
         ];

         if (Schema::hasColumn('interaction', 'cuepointtag')) {
            $interactionSelect[] = DB::raw('GROUP_CONCAT(DISTINCT NULLIF(cuepointtag, \'\') SEPARATOR \' | \') as cuepointtag');
         } else {
            $interactionSelect[] = DB::raw('NULL as cuepointtag');
         }

         $interactions = Interaction::select($interactionSelect)
            ->whereIn('sessionid', $SessionsIds )
            ->whereIn('projectid', $allowedProjectIds)
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
           ->where('user_id', Auth::id())
           ->value('name');

           $int->nameProject = $projectName;
           Log::info('NAME OF PROJECT:');
           Log::info($projectName);
        }
        Log::info($interactions);


        $customFields = [];
        if (isset($cliente)) {
            $customFields = $this->getCustomerCustomFieldPayload($cliente->id, Auth::id());
        }

        return response()->json([
            'success' => 'Y',
            'customers' => $cliente,
            'iteractions' => $interactions,
            'custom_fields' => $customFields,
        ]);
    }

    //Delete Customer By Id
    public function deleteCustomer(Request $request){
        Log::info('_________________ deleteCustomer ___________________________');
        Log::info($request);

        $customerId = intval($request->CustomerId);
        if($customerId <= 0){
            return response()->json(['success' => 'N', 'message' => 'ID de cliente inválido']);
        }

        $projectIds = Project::where('user_id', Auth::id())->pluck('id');

        $hasPermission = CustomerProjects::where('customerId', $customerId)
            ->whereIn('projectId', $projectIds)
            ->exists();

        if(!$hasPermission){
            return response()->json(['success' => 'N', 'message' => 'No tiene permisos para borrar registro']);
        }

        try {
            DB::beginTransaction();

            CustomerProjects::where('customerId', $customerId)
                ->whereIn('projectId', $projectIds)
                ->delete();

            $hasRemainingRelations = CustomerProjects::where('customerId', $customerId)->exists();
            if(!$hasRemainingRelations){
                CrmCustomFieldValue::where('customer_id', $customerId)->delete();
                Customer::where('id', $customerId)->delete();
            }

            DB::commit();
            return response()->json(['success' => 'Y']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('deleteCustomer ERROR: ' . $th->getMessage());
            return response()->json(['success' => 'N', 'message' => 'No se pudo eliminar el registro']);
        }
    }

    public function updateCustomer(Request $request)
    {
        Log::info('_________________ updateCustomer ___________________________');
        Log::info($request);

        $customerId = intval($request->CustomerId);
        if ($customerId <= 0) {
            return response()->json(['success' => 'N', 'message' => 'ID de cliente inválido']);
        }

        $projectIds = Project::where('user_id', Auth::id())->pluck('id');
        $hasPermission = CustomerProjects::where('customerId', $customerId)
            ->whereIn('projectId', $projectIds)
            ->exists();

        if (!$hasPermission) {
            return response()->json(['success' => 'N', 'message' => 'No tiene permisos para editar este registro']);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'tel' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'city' => 'nullable|string|max:50',
            'state' => 'nullable|string|max:50',
            'cp' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:50',
            'tags' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 'N',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $customer = Customer::find($customerId);
        if (!$customer) {
            return response()->json(['success' => 'N', 'message' => 'Cliente no encontrado']);
        }

        try {
            DB::beginTransaction();

            $customer->name = $this->normalizeNullableText($request->name, 255);
            $customer->email = $this->normalizeNullableText($request->email, 255);
            $customer->tel = $this->normalizeNullableText($request->tel, 20);
            $customer->address = $this->normalizeNullableText($request->address, 255);
            $customer->birthday = $this->normalizeNullableText($request->birthday, 25);
            $customer->city = $this->normalizeNullableText($request->city, 50);
            $customer->state = $this->normalizeNullableText($request->state, 50);
            $customer->cp = $this->normalizeNullableText($request->cp, 10);
            $customer->country = $this->normalizeNullableText($request->country, 50);

            if (Schema::hasColumn('crm', 'tags')) {
                $customer->tags = $this->normalizeNullableText($request->tags, 500);
            }

            $customer->save();
            $this->syncCustomFieldValuesFromCrmEditor($customer->id, $request->input('crm_custom_field_data'), Auth::id());

            DB::commit();
            return response()->json(['success' => 'Y']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('updateCustomer ERROR: ' . $th->getMessage());
            return response()->json(['success' => 'N', 'message' => 'No se pudo actualizar el registro']);
        }
    }




    //*****************|| POST ||****************************/
    //*******************************************************/

    public function storeCustomField(Request $request)
    {
        $validated = $request->validateWithBag('crmCustomFields', [
            'name' => [
                'required',
                'string',
                'max:120',
                Rule::unique('crm_custom_fields')->where(function ($query) {
                    return $query->where('userid', Auth::id());
                }),
            ],
            'slug' => [
                'nullable',
                'string',
                'max:120',
            ],
            'type' => [
                'nullable',
                'string',
                Rule::in(['text', 'textarea', 'email', 'tel', 'date', 'checkbox', 'radio']),
            ],
        ]);

        $slug = $this->buildCustomFieldSlug(
            $validated['slug'] ?? $validated['name'],
            Auth::id()
        );

        CrmCustomField::create([
            'userid' => Auth::id(),
            'name' => trim($validated['name']),
            'slug' => $slug,
            'type' => $validated['type'] ?? 'text',
        ]);

        return Redirect::route('crm')->with('crm_custom_fields_success', 'Campo CRM creado correctamente.');
    }

    public function updateCustomField(Request $request, $id)
    {
        $customField = CrmCustomField::where('userid', Auth::id())->findOrFail($id);

        $validated = $request->validateWithBag('crmCustomFields', [
            'name' => [
                'required',
                'string',
                'max:120',
                Rule::unique('crm_custom_fields')->ignore($customField->id)->where(function ($query) {
                    return $query->where('userid', Auth::id());
                }),
            ],
            'slug' => [
                'nullable',
                'string',
                'max:120',
            ],
            'type' => [
                'nullable',
                'string',
                Rule::in(['text', 'textarea', 'email', 'tel', 'date', 'checkbox', 'radio']),
            ],
        ]);

        $customField->name = trim($validated['name']);
        $customField->slug = $this->buildCustomFieldSlug(
            $validated['slug'] ?? $validated['name'],
            Auth::id(),
            $customField->id
        );
        $customField->type = $validated['type'] ?? $customField->type ?? 'text';
        $customField->save();

        return Redirect::route('crm')->with('crm_custom_fields_success', 'Campo CRM actualizado correctamente.');
    }

    public function destroyCustomField($id)
    {
        $customField = CrmCustomField::where('userid', Auth::id())->findOrFail($id);

        CrmCustomFieldValue::where('crm_custom_field_id', $customField->id)->delete();
        $customField->delete();

        return Redirect::route('crm')->with('crm_custom_fields_success', 'Campo CRM eliminado correctamente.');
    }

    public function storeTag(Request $request)
    {
        if (!Schema::hasTable('crm_tags')) {
            return Redirect::route('crm')->withErrors([
                'name' => 'La tabla de tags CRM no existe todavia. Ejecuta las migraciones pendientes.',
            ], 'crmTags');
        }

        $validated = $request->validateWithBag('crmTags', [
            'name' => [
                'required',
                'string',
                'max:120',
                Rule::unique('crm_tags')->where(function ($query) {
                    return $query->where('userid', Auth::id());
                }),
            ],
            'slug' => [
                'nullable',
                'string',
                'max:120',
            ],
        ]);

        $slug = $this->buildTagSlug(
            $validated['slug'] ?? $validated['name'],
            Auth::id()
        );

        CrmTag::create([
            'userid' => Auth::id(),
            'name' => trim($validated['name']),
            'slug' => $slug,
        ]);

        return Redirect::route('crm')->with('crm_tags_success', 'Tag CRM creado correctamente.');
    }

    public function updateTag(Request $request, $id)
    {
        if (!Schema::hasTable('crm_tags')) {
            return Redirect::route('crm')->withErrors([
                'name' => 'La tabla de tags CRM no existe todavia. Ejecuta las migraciones pendientes.',
            ], 'crmTags');
        }

        $tag = CrmTag::where('userid', Auth::id())->findOrFail($id);

        $validated = $request->validateWithBag('crmTags', [
            'name' => [
                'required',
                'string',
                'max:120',
                Rule::unique('crm_tags')->ignore($tag->id)->where(function ($query) {
                    return $query->where('userid', Auth::id());
                }),
            ],
            'slug' => [
                'nullable',
                'string',
                'max:120',
            ],
        ]);

        $tag->name = trim($validated['name']);
        $tag->slug = $this->buildTagSlug(
            $validated['slug'] ?? $validated['name'],
            Auth::id(),
            $tag->id
        );
        $tag->save();

        return Redirect::route('crm')->with('crm_tags_success', 'Tag CRM actualizado correctamente.');
    }

    public function destroyTag($id)
    {
        if (!Schema::hasTable('crm_tags')) {
            return Redirect::route('crm')->withErrors([
                'name' => 'La tabla de tags CRM no existe todavia. Ejecuta las migraciones pendientes.',
            ], 'crmTags');
        }

        $tag = CrmTag::where('userid', Auth::id())->findOrFail($id);
        $tag->delete();

        return Redirect::route('crm')->with('crm_tags_success', 'Tag CRM eliminado correctamente.');
    }

    public function saveVisibleColumns(Request $request)
    {
        $requestedColumns = $request->input('columns', []);
        $crmCustomFields = CrmCustomField::where('userid', Auth::id())
            ->orderBy('name', 'asc')
            ->get();
        $allowedColumns = collect($this->getCrmColumnDefinitions($crmCustomFields))->pluck('key')->all();
        $visibleColumns = collect(is_array($requestedColumns) ? $requestedColumns : [])
            ->map(function ($column) {
                return trim((string) $column);
            })
            ->filter(function ($column) use ($allowedColumns) {
                return in_array($column, $allowedColumns, true);
            })
            ->unique()
            ->values()
            ->all();

        if (!count($visibleColumns)) {
            return response()->json([
                'success' => 'N',
                'message' => 'Selecciona al menos una columna.',
            ], 422);
        }

        UserConfig::setConfigParam(
            'crm_visible_columns',
            implode(',', $visibleColumns),
            'Columnas visibles de la tabla CRM por usuario'
        );

        return response()->json([
            'success' => 'Y',
            'columns' => $visibleColumns,
        ]);
    }

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
        $customerId = null;
        $projectOwnerId = null;

        if ($request['projectid']) {
            $projectOwnerId = Project::where('id', $request['projectid'])->value('user_id');
        }

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
                'tel'=>$request['f-tel'] ,
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

        $this->saveCustomFieldValues($customerId, $request->input('crm_custom_field_data'), $projectOwnerId);

        $project = Project::find($request['projectid']);
        $customer = Customer::find($customerId);
        app(WebhookDispatcher::class)->dispatch('lead.created', $project, [
            'customer' => $customer ? $customer->toArray() : null,
            'customer_id' => $customerId,
            'session_id' => $request['_token'],
            'form_fields' => collect($request->all())->filter(function ($value, $key) {
                return strpos($key, 'f-') === 0;
            })->all(),
            'custom_fields' => $request->input('crm_custom_field_data'),
        ]);

        return response()->json(['success' => 'Y', 'customer_id' => $customerId]);
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

    protected function buildCustomFieldSlug($source, $userId, $ignoreId = null)
    {
        $baseSlug = Str::slug((string) $source, '_');
        if (!$baseSlug) {
            $baseSlug = 'campo_personalizado';
        }

        $slug = $baseSlug;
        $suffix = 2;

        while (
            CrmCustomField::where('userid', $userId)
                ->where('slug', $slug)
                ->when($ignoreId, function ($query) use ($ignoreId) {
                    return $query->where('id', '!=', $ignoreId);
                })
                ->exists()
        ) {
            $slug = $baseSlug . '_' . $suffix;
            $suffix++;
        }

        return $slug;
    }

    protected function buildTagSlug($source, $userId, $ignoreId = null)
    {
        $baseSlug = Str::slug((string) $source, '_');
        if (!$baseSlug) {
            $baseSlug = 'crm_tag';
        }

        $slug = $baseSlug;
        $suffix = 2;

        while (
            CrmTag::where('userid', $userId)
                ->where('slug', $slug)
                ->when($ignoreId, function ($query) use ($ignoreId) {
                    return $query->where('id', '!=', $ignoreId);
                })
                ->exists()
        ) {
            $slug = $baseSlug . '_' . $suffix;
            $suffix++;
        }

        return $slug;
    }

    protected function normalizeNullableText($value, $maxLength = null)
    {
        if ($value === null) {
            return null;
        }

        $stringValue = trim((string) $value);
        if ($stringValue === '') {
            return null;
        }

        if ($maxLength !== null) {
            return substr($stringValue, 0, (int) $maxLength);
        }

        return $stringValue;
    }

    protected function saveCustomFieldValues($customerId, $payload, $projectOwnerId)
    {
        if (!$customerId || !$payload || !$projectOwnerId) {
            return;
        }

        $decoded = json_decode($payload, true);
        if (!is_array($decoded) || !count($decoded)) {
            return;
        }

        $fieldIds = collect($decoded)
            ->pluck('id')
            ->map(function ($id) {
                return intval($id);
            })
            ->filter(function ($id) {
                return $id > 0;
            })
            ->unique()
            ->values();

        if ($fieldIds->isEmpty()) {
            return;
        }

        $definitions = CrmCustomField::where('userid', $projectOwnerId)
            ->whereIn('id', $fieldIds->all())
            ->get()
            ->keyBy('id');

        foreach ($decoded as $entry) {
            $fieldId = intval($entry['id'] ?? 0);
            if (!$fieldId || !$definitions->has($fieldId)) {
                continue;
            }

            $value = $entry['value'] ?? null;
            $normalizedValue = $this->normalizeCustomFieldValueForStorage($value);

            if ($normalizedValue === null) {
                continue;
            }

            CrmCustomFieldValue::updateOrCreate(
                [
                    'customer_id' => $customerId,
                    'crm_custom_field_id' => $fieldId,
                ],
                [
                    'value' => $normalizedValue,
                ]
            );
        }
    }

    protected function syncCustomFieldValuesFromCrmEditor($customerId, $payload, $userId)
    {
        if (!$customerId || !$userId || !$payload) {
            return;
        }

        $decoded = json_decode($payload, true);
        if (!is_array($decoded) || !count($decoded)) {
            return;
        }

        $fieldIds = collect($decoded)
            ->pluck('id')
            ->map(function ($id) {
                return intval($id);
            })
            ->filter(function ($id) {
                return $id > 0;
            })
            ->unique()
            ->values();

        if ($fieldIds->isEmpty()) {
            return;
        }

        $definitions = CrmCustomField::where('userid', $userId)
            ->whereIn('id', $fieldIds->all())
            ->get()
            ->keyBy('id');

        foreach ($decoded as $entry) {
            $fieldId = intval($entry['id'] ?? 0);
            if (!$fieldId || !$definitions->has($fieldId)) {
                continue;
            }

            $value = $entry['value'] ?? null;
            $normalizedValue = null;

            if (is_bool($value)) {
                $normalizedValue = json_encode(['type' => 'boolean', 'value' => $value], JSON_UNESCAPED_UNICODE);
            } else {
                $normalizedValue = $this->normalizeCustomFieldValueForStorage($value);
            }

            if ($normalizedValue === null) {
                CrmCustomFieldValue::where('customer_id', $customerId)
                    ->where('crm_custom_field_id', $fieldId)
                    ->delete();
                continue;
            }

            CrmCustomFieldValue::updateOrCreate(
                [
                    'customer_id' => $customerId,
                    'crm_custom_field_id' => $fieldId,
                ],
                [
                    'value' => $normalizedValue,
                ]
            );
        }
    }

    protected function normalizeCustomFieldValueForStorage($value)
    {
        if (is_array($value)) {
            $filtered = array_values(array_filter($value, function ($item) {
                return trim((string) $item) !== '';
            }));

            return count($filtered)
                ? json_encode(['type' => 'array', 'value' => $filtered], JSON_UNESCAPED_UNICODE)
                : null;
        }

        if (is_bool($value)) {
            return $value
                ? json_encode(['type' => 'boolean', 'value' => true], JSON_UNESCAPED_UNICODE)
                : null;
        }

        if ($value === null) {
            return null;
        }

        $stringValue = trim((string) $value);
        return $stringValue !== '' ? $stringValue : null;
    }

    protected function decodeCustomFieldValue($value)
    {
        if ($value === null || $value === '') {
            return '';
        }

        $decoded = json_decode($value, true);
        if (
            json_last_error() === JSON_ERROR_NONE
            && is_array($decoded)
            && isset($decoded['type'])
            && array_key_exists('value', $decoded)
        ) {
            if ($decoded['type'] === 'array' && is_array($decoded['value'])) {
                return $decoded['value'];
            }

            if ($decoded['type'] === 'boolean') {
                return (bool) $decoded['value'];
            }
        }

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        return $value;
    }

    protected function getCustomerCustomFieldPayload($customerId, $userId)
    {
        $customFields = CrmCustomField::where('userid', $userId)
            ->orderBy('name', 'asc')
            ->get();

        if (!$customFields->count()) {
            return [];
        }

        $values = CrmCustomFieldValue::where('customer_id', $customerId)
            ->whereIn('crm_custom_field_id', $customFields->pluck('id')->all())
            ->get()
            ->keyBy('crm_custom_field_id');

        return $customFields->map(function ($field) use ($values) {
            $valueRow = $values->get($field->id);

            return [
                'id' => $field->id,
                'name' => $field->name,
                'slug' => $field->slug,
                'type' => $field->type,
                'value' => $this->decodeCustomFieldValue(optional($valueRow)->value),
            ];
        })->values()->all();
    }

    protected function getCrmColumnDefinitions($crmCustomFields = null)
    {
        $definitions = [
            ['key' => 'row_number', 'label' => '#'],
            ['key' => 'name', 'label' => __('crm.name')],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'tel', 'label' => __('crm.phone')],
            ['key' => 'address', 'label' => __('crm.address')],
            ['key' => 'birthday', 'label' => __('crm.birthday')],
            ['key' => 'city', 'label' => __('crm.city')],
            ['key' => 'state', 'label' => __('crm.state')],
            ['key' => 'cp', 'label' => __('crm.zip')],
            ['key' => 'country', 'label' => __('crm.country')],
            ['key' => 'tags', 'label' => __('crm.tags')],
            ['key' => 'created_at', 'label' => __('crm.created')],
        ];

        $customFields = $crmCustomFields ?: CrmCustomField::where('userid', Auth::id())
            ->orderBy('name', 'asc')
            ->get();

        foreach ($customFields as $field) {
            $definitions[] = [
                'key' => 'custom_' . $field->id,
                'label' => $field->name,
                'is_custom' => true,
                'custom_field_id' => $field->id,
            ];
        }

        return $definitions;
    }

    protected function getVisibleCrmColumns($crmColumnDefinitions = null)
    {
        $definitions = $crmColumnDefinitions ?: $this->getCrmColumnDefinitions();
        $defaultColumns = collect($definitions)->pluck('key')->all();
        $storedColumns = UserConfig::getConfigParam('crm_visible_columns');

        if (!$storedColumns) {
            return $defaultColumns;
        }

        $visibleColumns = collect(explode(',', $storedColumns))
            ->map(function ($column) {
                return trim((string) $column);
            })
            ->filter(function ($column) use ($defaultColumns) {
                return in_array($column, $defaultColumns, true);
            })
            ->unique()
            ->values()
            ->all();

        return count($visibleColumns) ? $visibleColumns : $defaultColumns;
    }

    protected function buildCrmTableRows($customers, $crmCustomFields = null)
    {
        $customFields = $crmCustomFields ?: CrmCustomField::where('userid', Auth::id())
            ->orderBy('name', 'asc')
            ->get();

        return collect($customers)->values()->map(function ($customer, $index) use ($customFields) {
            $customFieldValues = $customer->relationLoaded('customFieldValues')
                ? $customer->customFieldValues->keyBy('crm_custom_field_id')
                : collect();

            $row = [
                'id' => $customer->id,
                'row_number' => $index + 1,
                'name' => $customer->name ?? '',
                'email' => $customer->email ?? '',
                'tel' => $customer->tel ?? '',
                'address' => $customer->address ?? '',
                'birthday' => $customer->birthday ?? '',
                'city' => $customer->city ?? '',
                'state' => $customer->state ?? '',
                'cp' => $customer->cp ?? '',
                'country' => $customer->country ?? $customer->contry ?? '',
                'tags' => Schema::hasColumn('crm', 'tags') ? ($customer->tags ?? '') : '',
                'created_at' => $customer->created_at ? $customer->created_at->format('Y-m-d H:i:s') : '',
            ];

            foreach ($customFields as $field) {
                $valueRow = $customFieldValues->get($field->id);
                $decodedValue = $valueRow ? $this->decodeCustomFieldValue($valueRow->value) : '';
                $row['custom_' . $field->id] = $this->formatCustomFieldValueForTable($decodedValue);
            }

            return $row;
        })->all();
    }

    protected function formatCustomFieldValueForTable($value)
    {
        if (is_array($value)) {
            return implode(', ', array_filter($value, function ($item) {
                return trim((string) $item) !== '';
            }));
        }

        if ($value === true) {
            return 'Si';
        }

        if ($value === false || $value === null) {
            return '';
        }

        return trim((string) $value);
    }




}
