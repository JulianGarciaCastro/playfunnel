<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

use App\Models\CuePoint;
use App\Models\Project;
use App\Models\Library;

class ProjectLibrary extends Model
{
    use HasFactory;
    
    protected $table = 'projectlibrary';
    
    protected $with = ['library'];
    
    protected $touches = ['project'];
    
    //public function project() { return $this->belongsTo(Project::class, 'projectid'); }
    
    
    public function cuePoints(){
        return $this->hasMany(CuePoint::class, 'projectlibraryid', 'id');
    }
    
    
    public function library(){
        return $this->hasOne(Library::class, 'id', 'libraryid');
    }
    
    
    public function project(){
        return $this->belongsTo(Project::class, 'projectid', 'id');
    }
    
        
    public function delete(){
        $this->cuePoints->each(function ($cuePoints) {
            Log::debug('delete() Cuepoint each: ' . $cuePoints->id);
            $cuePoints->delete();
        });
        
        Log::debug('delete() PorjectLibrary ' . $this->id);
        $this->cuePoints()->delete();
            
        return parent::delete();
    }
}