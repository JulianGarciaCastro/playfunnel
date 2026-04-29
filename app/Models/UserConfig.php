<<<<<<< HEAD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserConfig extends Model
{
    use HasFactory;
    
    protected $table = 'users_config';
    
    protected $primaryKey = 'id';
    public $incrementing  = false;
    public $timestamps    = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'user_id',
            'parameter_name',
            'parameter_value',
            'parameter_description'
        ];
 
    public static function setConfigParam($param_name, $param_value, $param_desc=""){
        $userConfig = UserConfig::where('user_id',        Auth::id())
                                ->where('parameter_name', $param_name)
                                ->first();        

        //Log::debug($userConfig);

        if(!isset($userConfig)){
            $userConfig                 = new UserConfig();
            $userConfig->user_id        = Auth::id();
            $userConfig->parameter_name = $param_name;
        } 

        $userConfig->parameter_value       = $param_value;
        if($param_desc != ""){
            $userConfig->parameter_description = $param_desc;
        }

        $userConfig->save();
    }
    
    public static function getConfigParam($param_name){

        $userConfig = UserConfig::where('user_id',        Auth::id())
                                ->where('parameter_name', $param_name)
                                ->first(); 
        if(isset($userConfig))
            return $userConfig->parameter_value;
    }
    
=======
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserConfig extends Model
{
    use HasFactory;
    
    protected $table = 'users_config';
    
    protected $primaryKey = 'id';
    public $incrementing  = false;
    public $timestamps    = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'user_id',
            'parameter_name',
            'parameter_value',
            'parameter_description'
        ];
 
    public static function setConfigParam($param_name, $param_value, $param_desc=""){
        $userConfig = UserConfig::where('user_id',        Auth::id())
                                ->where('parameter_name', $param_name)
                                ->first();        

        //Log::debug($userConfig);

        if(!isset($userConfig)){
            $userConfig                 = new UserConfig();
            $userConfig->user_id        = Auth::id();
            $userConfig->parameter_name = $param_name;
        } 

        $userConfig->parameter_value       = $param_value;
        if($param_desc != ""){
            $userConfig->parameter_description = $param_desc;
        }

        $userConfig->save();
    }
    
    public static function getConfigParam($param_name){

        $userConfig = UserConfig::where('user_id',        Auth::id())
                                ->where('parameter_name', $param_name)
                                ->first(); 
        if(isset($userConfig))
            return $userConfig->parameter_value;
    }
    
>>>>>>> 0d6f5c2c18f02c9c7d0a3cb40a1c8218e42ba08f
}