<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

use App\Models\TypeOptionData;
use App\Models\Project;

class TypeOption extends Model
{
    use HasFactory;
    
    protected $table = 'type_option';
    protected $with  = ['typeOptionData'];
    
    protected $touches = ['project'];
    
    public function project() { return $this->belongsTo(Project::class, 'projectid'); }
    
    
    public function typeOptionData(){
        return $this->hasMany(TypeOptionData::class, 'typeoptionid', 'id')
                    ->orderBy('position', 'ASC');
    }
    
    
    
    public function delete(){
        $this->typeOptionData->each(function ($optionData) {
            Log::debug('delete() TypeOption each: ' . $optionData->id);
            $optionData->delete();
        });
            
        Log::debug('delete() TypeOption ' . $this->id);
        $this->typeOptionData()->delete();
        
        return parent::delete();
    }
    
}

/*
CREATE TABLE `type_option` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `projectid` int(11) NOT NULL,
  `libraryid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `cuepointid` int(11) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `options` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `text` varchar(500) DEFAULT NULL,
  `image` varchar(254) DEFAULT NULL,
  `content` longtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4;

*/ 