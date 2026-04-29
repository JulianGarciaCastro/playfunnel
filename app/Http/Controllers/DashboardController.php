<<<<<<< HEAD
<?php

namespace App\Http\Controllers;

use App\Models\Interaction;
use App\Models\Project;
use App\Models\User;
use App\Models\UserConfig;

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
use App\Models\CuePoint;
use App\Models\TypeOptionData;
use Ramsey\Uuid\Type\Integer;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;
use stdClass;

class DashboardController extends Controller
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

    public static function resetFilters(){
        UserConfig::setConfigParam('dashboard_dateFilter', '','Filtro de fecha a aplica: "" -> ver todo, "n-dias" -> ultimos n-días, "inicio-fin" -> Fecha inicio y fecha fin ');
        UserConfig::setConfigParam('dashboard_dateLastNDays', '','Ultimos N días a visualizar por defecto en el dashboard');
        UserConfig::setConfigParam('dashboard_dateStart', '','dateStart a visualizar por defecto en el dashboard');
        UserConfig::setConfigParam('dashboard_dateEnd',   '','dateEnd a visualizar por defecto en el dashboard');
        UserConfig::setConfigParam('dashboard_projectId', '--','Código de proyecto a visualizar por defecto en el dashboard');
        UserConfig::setConfigParam('dashboard_device',    'dv-all','Device a visualizar por defecto en el dashboard');
        UserConfig::setConfigParam('dashboard_dates',     'days','dates a visualizar por defecto en el dashboard');
    }

    public static function index(Request $request){

        if(!Auth::check()){
            return redirect()->guest(route('login'));
        }
        else{
            $firstInteractionDate = Interaction::getFirstInteactionDate();

            $user = User::find(Auth::id());

            $selectedProjectID = UserConfig::getConfigParam('dashboard_projectId');
            $dateFilter        = UserConfig::getConfigParam('dashboard_dateFilter');
            $dateNDays         = UserConfig::getConfigParam('dashboard_dateLastNDays');
            $dateStart         = UserConfig::getConfigParam('dashboard_dateStart');
            $dateEnd           = UserConfig::getConfigParam('dashboard_dateEnd');
            
            if(!$dateNDays || $dateNDays<= 0)
                $dateNDays = 1;

            $projects = Project::where('user_id', Auth::id())->get();

            $prject_ids = array();
            if( !$selectedProjectID && $selectedProjectID == "--" ){
                //Log::debug("Paso 1: selectedProjectID vacío");
                $prject_ids[] = $selectedProjectID;
            }else{
                foreach($projects as $project){
                    $prject_ids[] = $project->id;
                }
            }

            //Log::debug("\$prject_ids");
            //Log::debug(print_r($prject_ids,true));

            $totalInteractions = Interaction::totalInteractions();
            $totalCompleted    = Interaction::totalCompleted();

            /*
                Log::debug("Paso 2: selectedProjectID informado");
                $projects = Project::where('id', $selectedProjectID)->get();
            */

            $chartData = Interaction::select(DB::raw('DATE_FORMAT(created_at,\'%Y-%m\') as fecha'),
                                             DB::raw('COUNT(1) as interactions'),
                                             DB::raw('SUM(case when interactiontype=1 then 1 end) as completed'))
                        ->whereIn('projectid', $prject_ids )
                        ->groupBy(DB::raw('1'));

            if($dateFilter==""){
            }elseif($dateFilter=="n-dias"){
                $chartData = $chartData->where('created_at', '>=',DB::raw('CURDATE() - INTERVAL '. $dateNDays.'+1 DAY'));
            }elseif($dateFilter=="inicio-fin"){
                $chartData = $chartData->where('created_at', '>=',DB::raw('\''.$dateStart.'\''))
                                       ->where('created_at', '<=',DB::raw('\''.$dateEnd.'\''));
            }

            //Log::debug("\$chartData");
            //Log::debug($chartData->toSql());
            $chartData = $chartData->get();

            $tagOptionData = Interaction::select(
                DB::raw('coalesce(cuepointname,\'NULO\') as cuepointname'),
                DB::raw('coalesce(cuepointoptionname,\'NULO\')as cuepointoptionname'),
                DB::raw('count(ID) as interactions'))
            ->whereIn('projectid', $prject_ids )
            ->groupBy('cuepointname', 'cuepointoptionname')
            ->orderBy('cuepointname','asc')
            ->orderBy('interactions','desc');

            if($dateFilter==""){
            }elseif($dateFilter=="n-dias"){
                $tagOptionData = $tagOptionData->where('created_at', '>=',DB::raw('CURDATE() - INTERVAL '. $dateNDays.'+1 DAY'));
            }elseif($dateFilter=="inicio-fin"){
                $tagOptionData = $tagOptionData->where('created_at', '>=',DB::raw('\''.$dateStart.'\''))
                                       ->where('created_at', '<=',DB::raw('\''.$dateEnd.'\''));
            }

            //Log::debug("\$tagOptionData");
            //Log::debug($tagOptionData->toSql());
            $tagOptionData = $tagOptionData->get();

            $tableData = Interaction::select(
                'sessionid',
                DB::raw('GROUP_CONCAT(coalesce(cuepointoptionname,\'NULO\')SEPARATOR \' | \') as cuepointoptionname'),
                DB::raw('case when MAX(interactiontype)=0 then \'Interacción\' when  MAX(interactiontype)=1 then \'Completa\' else \'Otra\' end as actividad'),
                DB::raw('MIN(created_at) AS created_at'),
                DB::raw('MAX(loc_country_code) AS loc_country_code'),
                )
            ->whereIn('projectid', $prject_ids )
            ->groupBy('sessionid')
            ->orderBy('created_at','desc');

            if($dateFilter==""){
            }elseif($dateFilter=="n-dias"){
                $tableData = $tableData->where('created_at', '>=',DB::raw('CURDATE() - INTERVAL '. $dateNDays.'+1 DAY'));
            }elseif($dateFilter=="inicio-fin"){
                $tableData = $tableData->where('created_at', '>=',DB::raw('\''.$dateStart.'\''))
                                       ->where('created_at', '<=',DB::raw('\''.$dateEnd.'\''));
            }

            //Log::debug("\$tableData");
            //Log::debug($tableData->toSql());
            $tableData = $tableData->get();

            return view('dashboard', compact('projects','totalInteractions','totalCompleted','chartData','tagOptionData','tableData','firstInteractionDate'));
        }

        return Redirect::intended('login');

    }

    //DATOS DEL NUMERO DE INTERACIONES / COMPLETADAS
    public static function getChartData(Request $request){
        //Log::debug("-------------------------------------- total_interactions --------");
        //Log::debug(json_encode($interactions_by_cuepointname));


        if(Auth::check()){
            $user = User::find(Auth::id());

            $selectedProjectID = UserConfig::getConfigParam('dashboard_projectId');
            $dateFilter        = UserConfig::getConfigParam('dashboard_dateFilter');
            $dateNDays         = UserConfig::getConfigParam('dashboard_dateLastNDays');
            $dateStart         = UserConfig::getConfigParam('dashboard_dateStart');
            $dateEnd           = UserConfig::getConfigParam('dashboard_dateEnd');

            if(!$dateNDays || $dateNDays<= 0)
                $dateNDays = 1;
            
            $prject_ids = array();
            if($request->projectId != "--"){
                $prject_ids[] = $request->projectId;
            }else{
                $projects = Project::where('user_id', Auth::id())->get();
                foreach($projects as $project){
                    $prject_ids[] = $project->id;
                }
            }

            if($request->dates == "years"){
                $date_format = 'DATE_FORMAT(created_at,\'%Y\') as fecha';
            }elseif($request->dates == "week"){
                $date_format = 'DATE_FORMAT(created_at,\'%x-%v\') as fecha'; // lunes primer día de la semana
            }elseif($request->dates == "days"){
                $date_format = 'DATE_FORMAT(created_at,\'%Y-%m-%d\') as fecha';
            }else{ // Por defecto months
                $date_format = 'DATE_FORMAT(created_at,\'%Y-%m\') as fecha';
            }

            $selectedProject = UserConfig::getConfigParam('dashboard_projectId');

             $queryInteractions = Interaction::select(DB::raw($date_format),
                                             DB::raw('sessionid as sessionid'),
                                             DB::raw('SUM(case when interactiontype=0 then 1 end) as interactions'),
                                             DB::raw('SUM(case when interactiontype=1 then 1 end) as completed'))
                        ->whereIn('projectid', $prject_ids )
                        ->groupBy(DB::raw('1'),'sessionid');


            if($dateFilter==""){
            }elseif($dateFilter=="n-dias"){
                $queryInteractions = $queryInteractions->where('created_at', '>=',DB::raw('CURDATE() - INTERVAL '. $dateNDays.'+1 DAY'));
            }elseif($dateFilter=="inicio-fin"){
                $queryInteractions = $queryInteractions->where('created_at', '>=',DB::raw('\''.$dateStart.'\''))
                                        ->where('created_at', '<=',DB::raw('\''.$dateEnd.'\''));
            }

            if($request->device != null && $request->device != "dv-all"){
                $queryInteractions = $queryInteractions->where('device', $request->device );
                //echo "--> ".$request->device; exit();
            }


            $data = $queryInteractions->get();
            //Log::info('------------------------------INTERACTIONS:'.json_encode($data));

            //Agrupo Interaciones por Sessions
            $interaccionesPorSession = array();

            $Completed = 0;
            foreach ($data as $int) {

                if(isset($int)){
                    $Interactions = 0;
                       //Si no esta el Id del Cue lo creo
                    if (!isset( $interaccionesPorSession[$int->fecha])) {
                        $interaccionesPorSession[$int->fecha]['interaction'] = 1;
                        //Log::info('INT'.json_encode($int));
                        if($int['completed'] >= 1){
                            $interaccionesPorSession[$int->fecha]['completed'] = 1;
                            //Log::info('COMPLETED'.$interaccionesPorSession[$int->fecha]['completed']);
                        }

                    }else{
                        $interaccionesPorSession[$int->fecha]['interaction']++;

                        if($int['completed'] >= 1){
                            if(isset( $interaccionesPorSession[$int->fecha]['completed'])){
                                $interaccionesPorSession[$int->fecha]['completed']++;
                            }else{
                                $interaccionesPorSession[$int->fecha]['completed'] = 1;
                            }

                        }

                       /* if($int['completed'] == 1){
                            $conterCompleted ++;
                            if (!isset( $interaccionesPorSession['completedDates'][ $conterCompleted-1])) {
                                $interaccionesPorSession['completedDates'][ $conterCompleted-1] = $int->fecha;
                            }
                        }*/
                    }
                }

                   //$interaccionesPorSession['interactions'] = $conterInteractions;
                   //$interaccionesPorSession['completed'] =  $conterCompleted;
            }

           //Log::debug("-------------------------------------- dATA DATES--------");
           //Log::debug(json_encode($interaccionesPorSession));


            /*
            Log::debug("getChartData(\$request) -> \$queryInteractions->toSql()");
            Log::debug("projectid:");
            Log::debug($prject_ids);
            Log::debug("dateStart:".$request->dateStart);
            Log::debug("dateEnd:".  $request->dateEnd);
            Log::debug($sql);
            */
            //exit();
        }


        return response()->json(['success'=>'Y','data'=>$interaccionesPorSession]);
    }

    // ************************  PANEL DE OPTIONS
    public static function getTagOptionData(Request $request)
    {
        //$request->request->add(['user_id' => Auth::id()]);
        /**
         * [2022-01-16 21:24:37] development.DEBUG: array (
            '_token' => 'BsxJ6gG2w4K6thWfjBGCfY2feDrybi53m4LbZ6lY',
            'dateStart' => '2021-12-16',
            'dateEnd' => '2022-01-16',
            'projectId' => '40',
            'device' => 'dv-all',
            'dates' => 'months',
            )
         */


         //Autorización
        if (Auth::check()) {
            $user = User::find(Auth::id());

            $selectedProjectID = UserConfig::getConfigParam('dashboard_projectId');
            $dateFilter        = UserConfig::getConfigParam('dashboard_dateFilter');
            $dateNDays         = UserConfig::getConfigParam('dashboard_dateLastNDays');
            $dateStart         = UserConfig::getConfigParam('dashboard_dateStart');
            $dateEnd           = UserConfig::getConfigParam('dashboard_dateEnd');
            
            if(!$dateNDays || $dateNDays<= 0)
                $dateNDays = 1;

            $prject_ids = array();
            if ($request->projectId != "--" && $request->projectId != null) {
                $prject_ids[] = $request->projectId;
            } else {
                $projects = Project::where('user_id', Auth::id())->get();
                foreach ($projects as $project) {
                    $prject_ids[] = $project->id;
                }
            }
            //Log::debug("-------------------------------------- PROJECT IDs --------");
           // Log::debug($prject_ids);
            //creo consulta
            $queryInteractions = Interaction::select(
                DB::raw('id as id'),
                DB::raw('cuepointid as cuepointid'),
                DB::raw('coalesce(cuepointname,\'NULO\') as cuepointname'),
                DB::raw('coalesce(cuepointoptionid,\'NULO\')as cuepointoptionid'),
                DB::raw('coalesce(cuepointoptionname,\'NULO\')as cuepointoptionname'),
                DB::raw('count(ID) as interactions')
            )
            ->whereIn('projectid', $prject_ids)
                ->groupBy('id', 'cuepointname', 'cuepointid','cuepointoptionid', 'cuepointoptionname')
                ->orderBy('cuepointname', 'asc')
                ->orderBy('interactions', 'desc');

            //Aplico filtro
            if ($dateFilter == "") {
            } elseif ($dateFilter == "n-dias") {
                $queryInteractions = $queryInteractions->where('created_at', '>=', DB::raw('CURDATE() - INTERVAL '. $dateNDays.'+1 DAY'));
            } elseif ($dateFilter == "inicio-fin") {
                $queryInteractions = $queryInteractions->where('created_at', '>=', DB::raw('\'' . $dateStart . '\''))
                    ->where('created_at', '<=', DB::raw('\'' . $dateEnd . '\''));
            }

            if ($request->device != null && $request->device != "dv-all") {
                $queryInteractions = $queryInteractions->where('device', $request->device);
            }
            $data = $queryInteractions->get();
            //Log::info('--------------------------DATA');
            //Log::info($data);
            //Elimino los no type OPTION
            foreach ($data as $key => $row) {
                if ($row['cuepointid'] > 1 && $row['cuepointoptionid'] != Null && $row['cuepointoptionid'] != 'NULO' )  {
                    $cue = CuePoint::select()
                        ->where('id', $row['cuepointid'])
                        ->first();
                    if(!isset($cue)){
                        break;
                    }
                    if ($cue->type == 'OPTION') {
                        //Log::info('--------------------------IS OPTION');
                        //Log::info(json_encode($row));
                    } else {
                        unset($data[$key]);
                    }
                } else {
                    unset($data[$key]);
                }
            }

            //Creo Array de Interacciones por cuePointName
            $interactions_by_cuepointname = array();
            foreach ($data as $key => $row) {
                if (!isset($interactions_by_cuepointname[$row['cuepointname']])) {
                    $interactions_by_cuepointname[$row['cuepointname']] = $row['interactions'];
                } else {
                    $interactions_by_cuepointname[$row['cuepointname']] += $row['interactions'];
                }
            }

            //Log::debug("-------------------------------------- total_interactions by NAME--------");
            //Log::debug(json_encode($interactions_by_cuepointname));


            //Creo Array organizando
            $arrayById = array();
            foreach ($data as $key => $row) {
                if (!isset($arrayById[$row['cuepointid']])) {
                    $arrayById[$row['cuepointid']] = array();
                    array_push($arrayById[$row['cuepointid']],$row);
                } else {
                    array_push($arrayById[$row['cuepointid']],$row);
                }
            }

            //Creo Array Final con numero total de Score y objeto con cuepoint
            $score_options = array();
            foreach ($arrayById as $key => $interactions) {
                $scoreTotal = 0;
                $name = "";
                $ints = 0;

                foreach ($interactions as $dat => $int) {
                    //Log::debug("--------------------------------------*** INTERACTION ***--------");
                    //Log::debug(json_encode($int));
                     //get Name Cuepoint
                     $idcue = $int['cuepointid'];
                     $cueData = CuePoint::select()
                     ->where('id', $idcue)
                     ->first();
                     if(!isset($cueData) || $cueData['type'] != 'OPTION'){
                         break;
                     }
                     $name = $cueData['cuepointname'];


                    //get Name Option
                    $id = $int['cuepointoptionid'];
                    $cueOptionData = TypeOptionData::select()
                    ->where('id', $id)
                    ->first();
                    if(!isset($cueOptionData)){
                        break;
                    }
                    $int['cuepointoptionname'] = $cueOptionData['name'];



                     //Si no esta el Id del Cue lo creo
                    if (!isset(  $score_options[$int['cuepointid']])) {
                        $score_options[$int['cuepointid']] = array();
                    }

                    //Cuento Interacciones por Nombre OPTION y Creo campo con el cuepointoptionname en su ID correspondiente
                    if (!isset(  $score_options[$int['cuepointid']][$int['cuepointoptionname']])) {
                        $score_options[$int['cuepointid']][$int['cuepointoptionname']] = 1;
                        $scoreTotal ++;

                    } else {
                        $score_options[$int['cuepointid']][$int['cuepointoptionname']] ++;
                        $scoreTotal ++;

                    }
                }

                //Se vincula el total y el nombre
                $score_options[$int['cuepointid']]['score'] = $scoreTotal;
                $score_options[$int['cuepointid']]['name'] = $name;

                //Elimino las vacias
                if($scoreTotal <= 0){
                    unset($score_options[$int['cuepointid']]);
                }
            }
        }
        return response()->json(['success' => 'Y', 'data' => $score_options]);
    }

    // ************************  TABLE DATA
    public static function getInteractionTableData(Request $request){
        //Log::debug("XXXXXXXXXXXXXXXXXXXXXXX > ".$request->projectId);
        if(Auth::check()){
            $user = User::find(Auth::id());

            $selectedProjectID = UserConfig::getConfigParam('dashboard_projectId');
            $dateFilter        = UserConfig::getConfigParam('dashboard_dateFilter');
            $dateNDays         = UserConfig::getConfigParam('dashboard_dateLastNDays');
            $dateStart         = UserConfig::getConfigParam('dashboard_dateStart');
            $dateEnd           = UserConfig::getConfigParam('dashboard_dateEnd');
            
            if(!$dateNDays || $dateNDays<= 0)
                $dateNDays = 1;

            $prject_ids = array();
            if($request->projectId != "--"){
                $prject_ids[] = $request->projectId;
            }else{
                $projects = Project::where('user_id', Auth::id())->get();
                foreach($projects as $project){
                    $prject_ids[] = $project->id;
                }
            }
            //Log::debug($prject_ids);
            if($request->dates == "years"){
                $date_format = 'DATE_FORMAT(created_at,\'%Y\') as fecha';
            }elseif($request->dates == "week"){
                $date_format = 'DATE_FORMAT(created_at,\'%x-%v\') as fecha'; // lunes primer día de la semana
            }elseif($request->dates == "days"){
                $date_format = 'DATE_FORMAT(created_at,\'%Y-%m-%d\') as fecha';
            }else{ // Por defecto months
                $date_format = 'DATE_FORMAT(created_at,\'%Y-%m\') as fecha';
            }
            //Log::debug('-------------------  PROJECT  --------------------------------------');
            //Log::debug($prject_ids);

             $queryInteractions = Interaction::select(
                'sessionid',
                DB::raw('GROUP_CONCAT(coalesce(cuepointoptionname,\'NULO\')SEPARATOR \' | \') as cuepointoptionname'),
                DB::raw('case when MAX(interactiontype)=0 then \'Interacción\' when  MAX(interactiontype)=1 then \'Completa\' else \'Otra\' end as actividad'),
                DB::raw('MIN(created_at) AS created_at'),
                DB::raw('MAX(loc_country_code) AS loc_country_code'),
                DB::raw('MAX(loc_city) AS loc_city')
                )
                ->whereIn('projectid', $prject_ids )
                ->groupBy('sessionid')
                ->orderBy('created_at','desc');

            if($dateFilter==""){
            }elseif($dateFilter=="n-dias"){
                $queryInteractions = $queryInteractions->where('created_at', '>=',DB::raw('CURDATE() - INTERVAL '. $dateNDays.'+1 DAY'));
            }elseif($dateFilter=="inicio-fin"){
                $queryInteractions = $queryInteractions->where('created_at', '>=',DB::raw('\''.$dateStart.'\''))
                                        ->where('created_at', '<=',DB::raw('\''.$dateEnd.'\''));
            }

            if($request->device != null && $request->device != "dv-all"){
                $queryInteractions = $queryInteractions->where('device', $request->device );
                //echo "--> ".$request->device; exit();
            }

            //Log::debug("SQL-SQL-SQL-SQL-SQL-SQL-SQL-SQL-SQL-SQL-SQL-SQL-SQL-SQL-SQL-SQL-SQL-SQL-");
            //Log::debug($queryInteractions->toSql());

            Log::debug("getInteractionTableData().queryInteractions SQL:");
            $sql = vsprintf( str_replace('?', "'%s'", $queryInteractions->toSql()), $queryInteractions->getBindings() ); 
            Log::debug($sql);
            $data = $queryInteractions->get();

            //Log::debug('-------------------  TABLE  --------------------------------------'.$data);

            $table_html_content = '
                <table id="table_emails" class="tabla-correos w-100">
                <thead>
                    <tr>
                        <th class="Tth">ID</th>                       
                        <th class="Tth">'.__("dashboard.answer").'<!-- CUEPOINT NAME --></th>
                        <th class="Tth">'.__("dashboard.activity").'</th>
                        <th class="Tth">'.__("dashboard.date").'</th>                       
                        <th class="Tth">'.__("dashboard.city").'</th>
                        <th class="Tth">'.__("dashboard.country").'</th>
                        <th class="Tth"></th>
                    </tr>
                </thead>
                <tbody >
            ';
            foreach($data  as $key =>  $row){
                Log::debug('-------------------  ROW  --------------------------------------');
                Log::debug($row);
                $table_html_content .= '
                <tr>
                    <td class="Ttd">'.($key+1).'</td>                   
                    <td class="Ttd">'.$row->cuepointoptionname.'</td>
                    <td class="Ttd">'.$row->actividad.'</td>
                    <td class="Ttd">'.$row->created_at.'</td>
                    <td class="Ttd">'.$row->loc_city.'</td>
                    <td class="Ttd"><img src="https://flagicons.lipis.dev/flags/4x3/'.strtolower($row->loc_country_code).'.svg" width="20px"></td>                    
                    <td class="Ttd">...</td>
                </tr>
                ';
            }
            $table_html_content .= '
            </tbody>
            </table>
            ';

        }

        return response()->json(['success'=>'Y','data'=>$table_html_content]);
    }

    public static function saveDateFilter(Request $request){
        UserConfig::setConfigParam('dashboard_dateFilter',    (!isset($request->filter_type))?'':$request->filter_type,'Filtro de fecha a aplica: "" -> ver todo, "n-dias" -> ultimos n-días, "inicio-fin" -> Fecha inicio y fecha fin ');
        UserConfig::setConfigParam('dashboard_dateLastNDays', $request->date_filter_n_days_value,'Ultimos N días a visualizar por defecto en el dashboard');
        UserConfig::setConfigParam('dashboard_dateStart',     $request->start,'dateStart a visualizar por defecto en el dashboard');
        UserConfig::setConfigParam('dashboard_dateEnd',       $request->end,'dateEnd a visualizar por defecto en el dashboard');
        return response()->json(['success'=>'Y','data'=>'OK']);
    }

    public static function get_ip() {
        $ip = @$_SERVER['HTTP_CLIENT_IP']
        ? $_SERVER['HTTP_CLIENT_IP']
        : (@$_SERVER['HTTP_X_FORWARDED_FOR']
             ? $_SERVER['HTTP_X_FORWARDED_FOR']
             : $_SERVER['REMOTE_ADDR']);
        return $ip;
    }

    public static function get_ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
        $output = NULL;
        $output['city']           = "";
        $output['state']          = "";
        $output['country']        = "";
        $output['country_code']   = "";
        $output['continent']      = "";
        $output['continent_code'] = "";

        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city"           => @$ipdat->geoplugin_city,
                            "state"          => @$ipdat->geoplugin_regionName,
                            "country"        => @$ipdat->geoplugin_countryName,
                            "country_code"   => @$ipdat->geoplugin_countryCode,
                            "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }
        return $output;
    }

    public static function saveSessionData(Request $request){

        UserConfig::setConfigParam('dashboard_dateStart', $request->dateStart,'dateStart a visualizar por defecto en el dashboard');
        UserConfig::setConfigParam('dashboard_dateEnd',   $request->dateEnd,'dateEnd a visualizar por defecto en el dashboard');
        UserConfig::setConfigParam('dashboard_projectId', $request->projectId,'Código de proyecto a visualizar por defecto en el dashboard');
        UserConfig::setConfigParam('dashboard_device',    $request->device,'Device a visualizar por defecto en el dashboard');
        UserConfig::setConfigParam('dashboard_dates',     $request->dates,'dates a visualizar por defecto en el dashboard');

        /*
        Log::debug('===============   request->projectId   ==============');
        Log::debug($request->projectId);
        Log::debug('===============  ( dashboard_projectId )  ==============');
        Log::debug(session('dashboard_projectId'));
        Log::debug('');
        */
        return response()->json(['success'=>'Y']);
    }

    public static function get_client_device(){

        $mobile_Detect = new Mobile_Detect();
        if($mobile_Detect->isTablet()){
            $device = "dv-tablet";
        }elseif($mobile_Detect->isMobile()){
            $device = "dv-mobile";
        }else{
            $device = "dv-desktop";
        }

        return $device;
    }


}
=======
<?php

namespace App\Http\Controllers;

use App\Models\Interaction;
use App\Models\Project;
use App\Models\User;
use App\Models\UserConfig;

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
use App\Models\CuePoint;
use App\Models\TypeOptionData;
use Ramsey\Uuid\Type\Integer;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;
use stdClass;

class DashboardController extends Controller
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

    public static function resetFilters(){
        UserConfig::setConfigParam('dashboard_dateFilter', '','Filtro de fecha a aplica: "" -> ver todo, "n-dias" -> ultimos n-días, "inicio-fin" -> Fecha inicio y fecha fin ');
        UserConfig::setConfigParam('dashboard_dateLastNDays', '','Ultimos N días a visualizar por defecto en el dashboard');
        UserConfig::setConfigParam('dashboard_dateStart', '','dateStart a visualizar por defecto en el dashboard');
        UserConfig::setConfigParam('dashboard_dateEnd',   '','dateEnd a visualizar por defecto en el dashboard');
        UserConfig::setConfigParam('dashboard_projectId', '--','Código de proyecto a visualizar por defecto en el dashboard');
        UserConfig::setConfigParam('dashboard_device',    'dv-all','Device a visualizar por defecto en el dashboard');
        UserConfig::setConfigParam('dashboard_dates',     'days','dates a visualizar por defecto en el dashboard');
    }

    public static function index(Request $request){

        if(!Auth::check()){
            return redirect()->guest(route('login'));
        }
        else{
            $firstInteractionDate = Interaction::getFirstInteactionDate();

            $user = User::find(Auth::id());

            $selectedProjectID = UserConfig::getConfigParam('dashboard_projectId');
            $dateFilter        = UserConfig::getConfigParam('dashboard_dateFilter');
            $dateNDays         = UserConfig::getConfigParam('dashboard_dateLastNDays');
            $dateStart         = UserConfig::getConfigParam('dashboard_dateStart');
            $dateEnd           = UserConfig::getConfigParam('dashboard_dateEnd');
            
            if(!$dateNDays || $dateNDays<= 0)
                $dateNDays = 1;

            $projects = Project::where('user_id', Auth::id())->get();

            $prject_ids = array();
            if( !$selectedProjectID && $selectedProjectID == "--" ){
                //Log::debug("Paso 1: selectedProjectID vacío");
                $prject_ids[] = $selectedProjectID;
            }else{
                foreach($projects as $project){
                    $prject_ids[] = $project->id;
                }
            }

            //Log::debug("\$prject_ids");
            //Log::debug(print_r($prject_ids,true));

            $totalInteractions = Interaction::totalInteractions();
            $totalCompleted    = Interaction::totalCompleted();

            /*
                Log::debug("Paso 2: selectedProjectID informado");
                $projects = Project::where('id', $selectedProjectID)->get();
            */

            $chartData = Interaction::select(DB::raw('DATE_FORMAT(created_at,\'%Y-%m\') as fecha'),
                                             DB::raw('COUNT(1) as interactions'),
                                             DB::raw('SUM(case when interactiontype=1 then 1 end) as completed'))
                        ->whereIn('projectid', $prject_ids )
                        ->groupBy(DB::raw('1'));

            if($dateFilter==""){
            }elseif($dateFilter=="n-dias"){
                $chartData = $chartData->where('created_at', '>=',DB::raw('CURDATE() - INTERVAL '. $dateNDays.'+1 DAY'));
            }elseif($dateFilter=="inicio-fin"){
                $chartData = $chartData->where('created_at', '>=',DB::raw('\''.$dateStart.'\''))
                                       ->where('created_at', '<=',DB::raw('\''.$dateEnd.'\''));
            }

            //Log::debug("\$chartData");
            //Log::debug($chartData->toSql());
            $chartData = $chartData->get();

            $tagOptionData = Interaction::select(
                DB::raw('coalesce(cuepointname,\'NULO\') as cuepointname'),
                DB::raw('coalesce(cuepointoptionname,\'NULO\')as cuepointoptionname'),
                DB::raw('count(ID) as interactions'))
            ->whereIn('projectid', $prject_ids )
            ->groupBy('cuepointname', 'cuepointoptionname')
            ->orderBy('cuepointname','asc')
            ->orderBy('interactions','desc');

            if($dateFilter==""){
            }elseif($dateFilter=="n-dias"){
                $tagOptionData = $tagOptionData->where('created_at', '>=',DB::raw('CURDATE() - INTERVAL '. $dateNDays.'+1 DAY'));
            }elseif($dateFilter=="inicio-fin"){
                $tagOptionData = $tagOptionData->where('created_at', '>=',DB::raw('\''.$dateStart.'\''))
                                       ->where('created_at', '<=',DB::raw('\''.$dateEnd.'\''));
            }

            //Log::debug("\$tagOptionData");
            //Log::debug($tagOptionData->toSql());
            $tagOptionData = $tagOptionData->get();

            $tableData = Interaction::select(
                'sessionid',
                DB::raw('GROUP_CONCAT(coalesce(cuepointoptionname,\'NULO\')SEPARATOR \' | \') as cuepointoptionname'),
                DB::raw('case when MAX(interactiontype)=0 then \'Interacción\' when  MAX(interactiontype)=1 then \'Completa\' else \'Otra\' end as actividad'),
                DB::raw('MIN(created_at) AS created_at'),
                DB::raw('MAX(loc_country_code) AS loc_country_code'),
                )
            ->whereIn('projectid', $prject_ids )
            ->groupBy('sessionid')
            ->orderBy('created_at','desc');

            if($dateFilter==""){
            }elseif($dateFilter=="n-dias"){
                $tableData = $tableData->where('created_at', '>=',DB::raw('CURDATE() - INTERVAL '. $dateNDays.'+1 DAY'));
            }elseif($dateFilter=="inicio-fin"){
                $tableData = $tableData->where('created_at', '>=',DB::raw('\''.$dateStart.'\''))
                                       ->where('created_at', '<=',DB::raw('\''.$dateEnd.'\''));
            }

            //Log::debug("\$tableData");
            //Log::debug($tableData->toSql());
            $tableData = $tableData->get();

            return view('dashboard', compact('projects','totalInteractions','totalCompleted','chartData','tagOptionData','tableData','firstInteractionDate'));
        }

        return Redirect::intended('login');

    }

    //DATOS DEL NUMERO DE INTERACIONES / COMPLETADAS
    public static function getChartData(Request $request){
        //Log::debug("-------------------------------------- total_interactions --------");
        //Log::debug(json_encode($interactions_by_cuepointname));


        if(Auth::check()){
            $user = User::find(Auth::id());

            $selectedProjectID = UserConfig::getConfigParam('dashboard_projectId');
            $dateFilter        = UserConfig::getConfigParam('dashboard_dateFilter');
            $dateNDays         = UserConfig::getConfigParam('dashboard_dateLastNDays');
            $dateStart         = UserConfig::getConfigParam('dashboard_dateStart');
            $dateEnd           = UserConfig::getConfigParam('dashboard_dateEnd');

            if(!$dateNDays || $dateNDays<= 0)
                $dateNDays = 1;
            
            $prject_ids = array();
            if($request->projectId != "--"){
                $prject_ids[] = $request->projectId;
            }else{
                $projects = Project::where('user_id', Auth::id())->get();
                foreach($projects as $project){
                    $prject_ids[] = $project->id;
                }
            }

            if($request->dates == "years"){
                $date_format = 'DATE_FORMAT(created_at,\'%Y\') as fecha';
            }elseif($request->dates == "week"){
                $date_format = 'DATE_FORMAT(created_at,\'%x-%v\') as fecha'; // lunes primer día de la semana
            }elseif($request->dates == "days"){
                $date_format = 'DATE_FORMAT(created_at,\'%Y-%m-%d\') as fecha';
            }else{ // Por defecto months
                $date_format = 'DATE_FORMAT(created_at,\'%Y-%m\') as fecha';
            }

            $selectedProject = UserConfig::getConfigParam('dashboard_projectId');

             $queryInteractions = Interaction::select(DB::raw($date_format),
                                             DB::raw('sessionid as sessionid'),
                                             DB::raw('SUM(case when interactiontype=0 then 1 end) as interactions'),
                                             DB::raw('SUM(case when interactiontype=1 then 1 end) as completed'))
                        ->whereIn('projectid', $prject_ids )
                        ->groupBy(DB::raw('1'),'sessionid');


            if($dateFilter==""){
            }elseif($dateFilter=="n-dias"){
                $queryInteractions = $queryInteractions->where('created_at', '>=',DB::raw('CURDATE() - INTERVAL '. $dateNDays.'+1 DAY'));
            }elseif($dateFilter=="inicio-fin"){
                $queryInteractions = $queryInteractions->where('created_at', '>=',DB::raw('\''.$dateStart.'\''))
                                        ->where('created_at', '<=',DB::raw('\''.$dateEnd.'\''));
            }

            if($request->device != null && $request->device != "dv-all"){
                $queryInteractions = $queryInteractions->where('device', $request->device );
                //echo "--> ".$request->device; exit();
            }


            $data = $queryInteractions->get();
            //Log::info('------------------------------INTERACTIONS:'.json_encode($data));

            //Agrupo Interaciones por Sessions
            $interaccionesPorSession = array();

            $Completed = 0;
            foreach ($data as $int) {

                if(isset($int)){
                    $Interactions = 0;
                       //Si no esta el Id del Cue lo creo
                    if (!isset( $interaccionesPorSession[$int->fecha])) {
                        $interaccionesPorSession[$int->fecha]['interaction'] = 1;
                        //Log::info('INT'.json_encode($int));
                        if($int['completed'] >= 1){
                            $interaccionesPorSession[$int->fecha]['completed'] = 1;
                            //Log::info('COMPLETED'.$interaccionesPorSession[$int->fecha]['completed']);
                        }

                    }else{
                        $interaccionesPorSession[$int->fecha]['interaction']++;

                        if($int['completed'] >= 1){
                            if(isset( $interaccionesPorSession[$int->fecha]['completed'])){
                                $interaccionesPorSession[$int->fecha]['completed']++;
                            }else{
                                $interaccionesPorSession[$int->fecha]['completed'] = 1;
                            }

                        }

                       /* if($int['completed'] == 1){
                            $conterCompleted ++;
                            if (!isset( $interaccionesPorSession['completedDates'][ $conterCompleted-1])) {
                                $interaccionesPorSession['completedDates'][ $conterCompleted-1] = $int->fecha;
                            }
                        }*/
                    }
                }

                   //$interaccionesPorSession['interactions'] = $conterInteractions;
                   //$interaccionesPorSession['completed'] =  $conterCompleted;
            }

           //Log::debug("-------------------------------------- dATA DATES--------");
           //Log::debug(json_encode($interaccionesPorSession));


            /*
            Log::debug("getChartData(\$request) -> \$queryInteractions->toSql()");
            Log::debug("projectid:");
            Log::debug($prject_ids);
            Log::debug("dateStart:".$request->dateStart);
            Log::debug("dateEnd:".  $request->dateEnd);
            Log::debug($sql);
            */
            //exit();
        }


        return response()->json(['success'=>'Y','data'=>$interaccionesPorSession]);
    }

    // ************************  PANEL DE OPTIONS
    public static function getTagOptionData(Request $request)
    {
        //$request->request->add(['user_id' => Auth::id()]);
        /**
         * [2022-01-16 21:24:37] development.DEBUG: array (
            '_token' => 'BsxJ6gG2w4K6thWfjBGCfY2feDrybi53m4LbZ6lY',
            'dateStart' => '2021-12-16',
            'dateEnd' => '2022-01-16',
            'projectId' => '40',
            'device' => 'dv-all',
            'dates' => 'months',
            )
         */


         //Autorización
        if (Auth::check()) {
            $user = User::find(Auth::id());

            $selectedProjectID = UserConfig::getConfigParam('dashboard_projectId');
            $dateFilter        = UserConfig::getConfigParam('dashboard_dateFilter');
            $dateNDays         = UserConfig::getConfigParam('dashboard_dateLastNDays');
            $dateStart         = UserConfig::getConfigParam('dashboard_dateStart');
            $dateEnd           = UserConfig::getConfigParam('dashboard_dateEnd');
            
            if(!$dateNDays || $dateNDays<= 0)
                $dateNDays = 1;

            $prject_ids = array();
            if ($request->projectId != "--" && $request->projectId != null) {
                $prject_ids[] = $request->projectId;
            } else {
                $projects = Project::where('user_id', Auth::id())->get();
                foreach ($projects as $project) {
                    $prject_ids[] = $project->id;
                }
            }
            //Log::debug("-------------------------------------- PROJECT IDs --------");
           // Log::debug($prject_ids);
            //creo consulta
            $queryInteractions = Interaction::select(
                DB::raw('id as id'),
                DB::raw('cuepointid as cuepointid'),
                DB::raw('coalesce(cuepointname,\'NULO\') as cuepointname'),
                DB::raw('coalesce(cuepointoptionid,\'NULO\')as cuepointoptionid'),
                DB::raw('coalesce(cuepointoptionname,\'NULO\')as cuepointoptionname'),
                DB::raw('count(ID) as interactions')
            )
            ->whereIn('projectid', $prject_ids)
                ->groupBy('id', 'cuepointname', 'cuepointid','cuepointoptionid', 'cuepointoptionname')
                ->orderBy('cuepointname', 'asc')
                ->orderBy('interactions', 'desc');

            //Aplico filtro
            if ($dateFilter == "") {
            } elseif ($dateFilter == "n-dias") {
                $queryInteractions = $queryInteractions->where('created_at', '>=', DB::raw('CURDATE() - INTERVAL '. $dateNDays.'+1 DAY'));
            } elseif ($dateFilter == "inicio-fin") {
                $queryInteractions = $queryInteractions->where('created_at', '>=', DB::raw('\'' . $dateStart . '\''))
                    ->where('created_at', '<=', DB::raw('\'' . $dateEnd . '\''));
            }

            if ($request->device != null && $request->device != "dv-all") {
                $queryInteractions = $queryInteractions->where('device', $request->device);
            }
            $data = $queryInteractions->get();
            //Log::info('--------------------------DATA');
            //Log::info($data);
            //Elimino los no type OPTION
            foreach ($data as $key => $row) {
                if ($row['cuepointid'] > 1 && $row['cuepointoptionid'] != Null && $row['cuepointoptionid'] != 'NULO' )  {
                    $cue = CuePoint::select()
                        ->where('id', $row['cuepointid'])
                        ->first();
                    if(!isset($cue)){
                        break;
                    }
                    if ($cue->type == 'OPTION') {
                        //Log::info('--------------------------IS OPTION');
                        //Log::info(json_encode($row));
                    } else {
                        unset($data[$key]);
                    }
                } else {
                    unset($data[$key]);
                }
            }

            //Creo Array de Interacciones por cuePointName
            $interactions_by_cuepointname = array();
            foreach ($data as $key => $row) {
                if (!isset($interactions_by_cuepointname[$row['cuepointname']])) {
                    $interactions_by_cuepointname[$row['cuepointname']] = $row['interactions'];
                } else {
                    $interactions_by_cuepointname[$row['cuepointname']] += $row['interactions'];
                }
            }

            //Log::debug("-------------------------------------- total_interactions by NAME--------");
            //Log::debug(json_encode($interactions_by_cuepointname));


            //Creo Array organizando
            $arrayById = array();
            foreach ($data as $key => $row) {
                if (!isset($arrayById[$row['cuepointid']])) {
                    $arrayById[$row['cuepointid']] = array();
                    array_push($arrayById[$row['cuepointid']],$row);
                } else {
                    array_push($arrayById[$row['cuepointid']],$row);
                }
            }

            //Creo Array Final con numero total de Score y objeto con cuepoint
            $score_options = array();
            foreach ($arrayById as $key => $interactions) {
                $scoreTotal = 0;
                $name = "";
                $ints = 0;

                foreach ($interactions as $dat => $int) {
                    //Log::debug("--------------------------------------*** INTERACTION ***--------");
                    //Log::debug(json_encode($int));
                     //get Name Cuepoint
                     $idcue = $int['cuepointid'];
                     $cueData = CuePoint::select()
                     ->where('id', $idcue)
                     ->first();
                     if(!isset($cueData) || $cueData['type'] != 'OPTION'){
                         break;
                     }
                     $name = $cueData['cuepointname'];


                    //get Name Option
                    $id = $int['cuepointoptionid'];
                    $cueOptionData = TypeOptionData::select()
                    ->where('id', $id)
                    ->first();
                    if(!isset($cueOptionData)){
                        break;
                    }
                    $int['cuepointoptionname'] = $cueOptionData['name'];



                     //Si no esta el Id del Cue lo creo
                    if (!isset(  $score_options[$int['cuepointid']])) {
                        $score_options[$int['cuepointid']] = array();
                    }

                    //Cuento Interacciones por Nombre OPTION y Creo campo con el cuepointoptionname en su ID correspondiente
                    if (!isset(  $score_options[$int['cuepointid']][$int['cuepointoptionname']])) {
                        $score_options[$int['cuepointid']][$int['cuepointoptionname']] = 1;
                        $scoreTotal ++;

                    } else {
                        $score_options[$int['cuepointid']][$int['cuepointoptionname']] ++;
                        $scoreTotal ++;

                    }
                }

                //Se vincula el total y el nombre
                $score_options[$int['cuepointid']]['score'] = $scoreTotal;
                $score_options[$int['cuepointid']]['name'] = $name;

                //Elimino las vacias
                if($scoreTotal <= 0){
                    unset($score_options[$int['cuepointid']]);
                }
            }
        }
        return response()->json(['success' => 'Y', 'data' => $score_options]);
    }

    // ************************  TABLE DATA
    public static function getInteractionTableData(Request $request){
        //Log::debug("XXXXXXXXXXXXXXXXXXXXXXX > ".$request->projectId);
        if(Auth::check()){
            $user = User::find(Auth::id());

            $selectedProjectID = UserConfig::getConfigParam('dashboard_projectId');
            $dateFilter        = UserConfig::getConfigParam('dashboard_dateFilter');
            $dateNDays         = UserConfig::getConfigParam('dashboard_dateLastNDays');
            $dateStart         = UserConfig::getConfigParam('dashboard_dateStart');
            $dateEnd           = UserConfig::getConfigParam('dashboard_dateEnd');
            
            if(!$dateNDays || $dateNDays<= 0)
                $dateNDays = 1;

            $prject_ids = array();
            if($request->projectId != "--"){
                $prject_ids[] = $request->projectId;
            }else{
                $projects = Project::where('user_id', Auth::id())->get();
                foreach($projects as $project){
                    $prject_ids[] = $project->id;
                }
            }
            //Log::debug($prject_ids);
            if($request->dates == "years"){
                $date_format = 'DATE_FORMAT(created_at,\'%Y\') as fecha';
            }elseif($request->dates == "week"){
                $date_format = 'DATE_FORMAT(created_at,\'%x-%v\') as fecha'; // lunes primer día de la semana
            }elseif($request->dates == "days"){
                $date_format = 'DATE_FORMAT(created_at,\'%Y-%m-%d\') as fecha';
            }else{ // Por defecto months
                $date_format = 'DATE_FORMAT(created_at,\'%Y-%m\') as fecha';
            }
            //Log::debug('-------------------  PROJECT  --------------------------------------');
            //Log::debug($prject_ids);

             $queryInteractions = Interaction::select(
                'sessionid',
                DB::raw('GROUP_CONCAT(coalesce(cuepointoptionname,\'NULO\')SEPARATOR \' | \') as cuepointoptionname'),
                DB::raw('case when MAX(interactiontype)=0 then \'Interacción\' when  MAX(interactiontype)=1 then \'Completa\' else \'Otra\' end as actividad'),
                DB::raw('MIN(created_at) AS created_at'),
                DB::raw('MAX(loc_country_code) AS loc_country_code'),
                DB::raw('MAX(loc_city) AS loc_city')
                )
                ->whereIn('projectid', $prject_ids )
                ->groupBy('sessionid')
                ->orderBy('created_at','desc');

            if($dateFilter==""){
            }elseif($dateFilter=="n-dias"){
                $queryInteractions = $queryInteractions->where('created_at', '>=',DB::raw('CURDATE() - INTERVAL '. $dateNDays.'+1 DAY'));
            }elseif($dateFilter=="inicio-fin"){
                $queryInteractions = $queryInteractions->where('created_at', '>=',DB::raw('\''.$dateStart.'\''))
                                        ->where('created_at', '<=',DB::raw('\''.$dateEnd.'\''));
            }

            if($request->device != null && $request->device != "dv-all"){
                $queryInteractions = $queryInteractions->where('device', $request->device );
                //echo "--> ".$request->device; exit();
            }

            //Log::debug("SQL-SQL-SQL-SQL-SQL-SQL-SQL-SQL-SQL-SQL-SQL-SQL-SQL-SQL-SQL-SQL-SQL-SQL-");
            //Log::debug($queryInteractions->toSql());

            Log::debug("getInteractionTableData().queryInteractions SQL:");
            $sql = vsprintf( str_replace('?', "'%s'", $queryInteractions->toSql()), $queryInteractions->getBindings() ); 
            Log::debug($sql);
            $data = $queryInteractions->get();

            //Log::debug('-------------------  TABLE  --------------------------------------'.$data);

            $table_html_content = '
                <table id="table_emails" class="tabla-correos w-100">
                <thead>
                    <tr>
                        <th class="Tth">ID</th>                       
                        <th class="Tth">'.__("dashboard.answer").'<!-- CUEPOINT NAME --></th>
                        <th class="Tth">'.__("dashboard.activity").'</th>
                        <th class="Tth">'.__("dashboard.date").'</th>                       
                        <th class="Tth">'.__("dashboard.city").'</th>
                        <th class="Tth">'.__("dashboard.country").'</th>
                        <th class="Tth"></th>
                    </tr>
                </thead>
                <tbody >
            ';
            foreach($data  as $key =>  $row){
                Log::debug('-------------------  ROW  --------------------------------------');
                Log::debug($row);
                $table_html_content .= '
                <tr>
                    <td class="Ttd">'.($key+1).'</td>                   
                    <td class="Ttd">'.$row->cuepointoptionname.'</td>
                    <td class="Ttd">'.$row->actividad.'</td>
                    <td class="Ttd">'.$row->created_at.'</td>
                    <td class="Ttd">'.$row->loc_city.'</td>
                    <td class="Ttd"><img src="https://flagicons.lipis.dev/flags/4x3/'.strtolower($row->loc_country_code).'.svg" width="20px"></td>                    
                    <td class="Ttd">...</td>
                </tr>
                ';
            }
            $table_html_content .= '
            </tbody>
            </table>
            ';

        }

        return response()->json(['success'=>'Y','data'=>$table_html_content]);
    }

    public static function saveDateFilter(Request $request){
        UserConfig::setConfigParam('dashboard_dateFilter',    (!isset($request->filter_type))?'':$request->filter_type,'Filtro de fecha a aplica: "" -> ver todo, "n-dias" -> ultimos n-días, "inicio-fin" -> Fecha inicio y fecha fin ');
        UserConfig::setConfigParam('dashboard_dateLastNDays', $request->date_filter_n_days_value,'Ultimos N días a visualizar por defecto en el dashboard');
        UserConfig::setConfigParam('dashboard_dateStart',     $request->start,'dateStart a visualizar por defecto en el dashboard');
        UserConfig::setConfigParam('dashboard_dateEnd',       $request->end,'dateEnd a visualizar por defecto en el dashboard');
        return response()->json(['success'=>'Y','data'=>'OK']);
    }

    public static function get_ip() {
        $ip = @$_SERVER['HTTP_CLIENT_IP']
        ? $_SERVER['HTTP_CLIENT_IP']
        : (@$_SERVER['HTTP_X_FORWARDED_FOR']
             ? $_SERVER['HTTP_X_FORWARDED_FOR']
             : $_SERVER['REMOTE_ADDR']);
        return $ip;
    }

    public static function get_ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
        $output = NULL;
        $output['city']           = "";
        $output['state']          = "";
        $output['country']        = "";
        $output['country_code']   = "";
        $output['continent']      = "";
        $output['continent_code'] = "";

        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city"           => @$ipdat->geoplugin_city,
                            "state"          => @$ipdat->geoplugin_regionName,
                            "country"        => @$ipdat->geoplugin_countryName,
                            "country_code"   => @$ipdat->geoplugin_countryCode,
                            "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }
        return $output;
    }

    public static function saveSessionData(Request $request){

        UserConfig::setConfigParam('dashboard_dateStart', $request->dateStart,'dateStart a visualizar por defecto en el dashboard');
        UserConfig::setConfigParam('dashboard_dateEnd',   $request->dateEnd,'dateEnd a visualizar por defecto en el dashboard');
        UserConfig::setConfigParam('dashboard_projectId', $request->projectId,'Código de proyecto a visualizar por defecto en el dashboard');
        UserConfig::setConfigParam('dashboard_device',    $request->device,'Device a visualizar por defecto en el dashboard');
        UserConfig::setConfigParam('dashboard_dates',     $request->dates,'dates a visualizar por defecto en el dashboard');

        /*
        Log::debug('===============   request->projectId   ==============');
        Log::debug($request->projectId);
        Log::debug('===============  ( dashboard_projectId )  ==============');
        Log::debug(session('dashboard_projectId'));
        Log::debug('');
        */
        return response()->json(['success'=>'Y']);
    }

    public static function get_client_device(){

        $mobile_Detect = new Mobile_Detect();
        if($mobile_Detect->isTablet()){
            $device = "dv-tablet";
        }elseif($mobile_Detect->isMobile()){
            $device = "dv-mobile";
        }else{
            $device = "dv-desktop";
        }

        return $device;
    }


}
>>>>>>> 0d6f5c2c18f02c9c7d0a3cb40a1c8218e42ba08f
