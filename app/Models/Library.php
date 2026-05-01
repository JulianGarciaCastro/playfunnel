<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

use App\Models\ProjectLibrary;
use App\Models\Project;

class Library extends Model
{
    use HasFactory;
    
    protected $table = 'library';

    protected $fillable = [
            'url'
        ];
    
    public function projectLibrary(){
        Log::debug('projectLibrary() mirando ProjectLibs');
        
        return $this->hasMany(ProjectLibrary::class, 'libraryid', 'id');
    }
    
    
    public function project(){
        Log::debug('project() mirando Project');
        
        return $this->belongsToMany(Project::class, 'projectlibrary', 'libraryid', 'projectid');
    }
    
    public function projectPublish(){
        Log::debug('project() mirando projectPublish');
        
        return $this->hasMany(Project::class,  'publish_library_img', 'id');
    } 
    
    public function projectLanding(){
        Log::debug('project() mirando projectLanding');
        
        return $this->hasMany(Project::class,  'landing_library_img', 'id');
    }
    
    public function projectOption(){
        Log::debug('project() mirando projectOption');
        
        return $this->belongsToMany(Project::class,  'type_option_data', 'library_img','projectid');
    } 
}
