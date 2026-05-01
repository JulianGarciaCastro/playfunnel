<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

use App\Models\TypeBrowse;
use App\Models\TypeOption;

class CuePoint extends Model
{
    use HasFactory;
    
    protected $table = 'cuepoint';
    protected $with  = ['typeBrowse', 'typeOption', 'typeForm'];
    
    protected $touches = ['project'];
    
    public function project() { return $this->belongsTo(Project::class, 'projectid'); }
    
    
    public function typeBrowse(){
        return $this->hasOne(TypeBrowse::class, 'cuepointid', 'id');
    }

    
    public function typeOption(){
        return $this->hasOne(TypeOption::class, 'cuepointid', 'id');
    }
    
    public function typeForm(){
        return $this->hasOne(TypeForm::class, 'cuepointid', 'id');
    }
    
    
    public function cuePointData(){
        if($this->type == 'BROWSE')
            return $this->hasOne(TypeBrowse::class, 'cuepointid', 'id');
        
        if($this->type == 'OPTION')
            return $this->hasOne(TypeOption::class, 'cuepointid', 'id');
        
        return $this->hasOne(TypeForm::class, 'cuepointid', 'id');
    }
    
    
    
    public function delete(){
        
        //if($this->typeBrowse)
        //    $this->typeBrowse->each(function ($typeBrowse) {
        //        $typeBrowse->delete();
        //    });
        
        //if($this->typeOption)    
        //    $this->typeOption->each(function ($typeOption) {
        //        $typeOption->delete();
        //     });
        
        Log::debug('delete() Cuepoint ' . $this->id );
        $this->typeBrowse()->delete();
        $this->typeOption()->delete();
        $this->typeForm()->delete();
        return parent::delete();
    }
    
    
    public function deleteCuepointData(){
        
        if($this->type == 'BROWSE'){
            
            if( empty($this->typeBrowse)){
                return null;
            }
            
            $this->typeBrowse->delete();
        }
        elseif($this->type == 'OPTION'){
            
            if( empty($this->typeOption)){
                return null;
            }
            
            $this->typeOption->delete();
        }
        elseif($this->type == 'FORM'){
            
            if( empty($this->typeForm)){
                return null;
            }
            
            $this->typeForm->delete();
        }
    }
    
}