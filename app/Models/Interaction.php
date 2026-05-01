<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Interaction extends Model
{
    use HasFactory;
    
    protected $table = 'interaction';

    protected $primaryKey = 'id';
    public $incrementing  = true;
    public $timestamps    = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
	//'id',
        'sessionid',
        'projectid',
        'interactiontype',
        'loc_ip',
        'loc_city',
        'loc_state',
        'loc_country',
        'loc_country_code',
        'loc_continent',
        'loc_continent_code',
        'device',
        'cuepointid',
        'cuepointname',
        'cuepointoptionid',
        'cuepointoptionname'
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];
    
    /**
     * Total de interacciones
     */
    public static function totalInteractions(){

        $query = Project::join('interaction', 'project.id', '=', 'interaction.projectid')
               ->where('project.user_id',Auth::id())
               ->where('interaction.interactiontype', 0);

        $selectedProject = UserConfig::getConfigParam('dashboard_projectId');

        if($selectedProject && $selectedProject != "--"){
            $query = $query->where('project.id',$selectedProject);
        }
        
        Log::debug("totalInteractions().selectedProject:");
        Log::debug($selectedProject);
        Log::debug("");

        Log::debug("totalInteractions().totalInteractions:");
        Log::debug("\$query->toSql(): ");
        Log::debug($query->toSql());
        Log::debug("");

        $count = $query->count();

        return $count;
    }

    /**
     * Total de interacciones completadas
     */
    public static function totalCompleted(){
/*
        $count = Project::join('interaction', 'project.id', '=', 'interaction.projectid')
                ->where('project.user_id',Auth::id())
                ->where('interaction.interactiontype', 1)
                ->count();
*/

        $query = Project::join('interaction', 'project.id', '=', 'interaction.projectid')
                ->where('project.user_id',Auth::id())
                ->where('interaction.interactiontype', 1);

        $selectedProject = UserConfig::getConfigParam('dashboard_projectId');

        if($selectedProject && $selectedProject != "--"){
            $query = $query->where('project.id',$selectedProject);
        }

        Log::debug("totalCompleted:");
        Log::debug("\$query->toSql(): ");
        Log::debug($query->toSql());

        $count = $query->count();

        return $count;

    }

     /**
     * Total de interacciones
     */
    public static function getFirstInteactionDate(){
        $query = Project::join('interaction', 'project.id', '=', 'interaction.projectid')
               ->where('project.user_id',Auth::id())
               ->where('interaction.interactiontype', 0);

        $selectedProject = UserConfig::getConfigParam('dashboard_projectId');

        if($selectedProject && $selectedProject != "--"){
            $query = $query->where('project.id',$selectedProject);
        }
        
        $query = $query->selectRaw('min(interaction.created_at) as created_at');

        Log::debug("getFirstInteactionDate().selectedProject:");
        Log::debug($selectedProject);
        Log::debug("");

        Log::debug("getFirstInteactionDate():");
        Log::debug("\$query->toSql(): ");
        Log::debug($query->toSql());
        Log::debug("");

        if(count($query->get())>0){
            $firstRow = $query->get()[0];
            return substr($firstRow['created_at'],0,10);
        }
    }

}