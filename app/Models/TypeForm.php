<<<<<<< HEAD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

use App\Models\TypeOptionData;
use App\Models\Project;

class TypeForm extends Model
{
    use HasFactory;
    
    protected $table = 'type_form';
    //protected $with  = ['typeFormData'];
    
    protected $touches = ['project'];
    
    public function project() { return $this->belongsTo(Project::class, 'projectid'); }
    
    
    public function typeFormData(){
        return $this->hasMany(TypeFormData::class, 'typeformid', 'id')
                    ->orderBy('id', 'ASC');
    }
    
    
    
    public function delete(){
        $this->typeFormData->each(function ($formData) {
            Log::debug('delete() TypeForm each: ' . $formData->id);
            $formData->delete();
        });
            
        Log::debug('delete() TypeForm ' . $this->id);
        $this->typeFormData()->delete();
        
        return parent::delete();
    }
    
}

/*
CREATE TABLE `type_form` (
  `id` 			bigint unsigned NOT NULL AUTO_INCREMENT,
  `userid` 		int NOT NULL,
  `projectid` 	int NOT NULL,
  `libraryid` 	int NOT NULL,
  `cuepointid` 	int NOT NULL,
  `content` 	longtext,
  `name` 		varchar(100) DEFAULT NULL,
  `sendto` 		varchar(100) DEFAULT NULL,
  `created_at` 	timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` 	timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
=======
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

use App\Models\TypeOptionData;
use App\Models\Project;

class TypeForm extends Model
{
    use HasFactory;
    
    protected $table = 'type_form';
    //protected $with  = ['typeFormData'];
    
    protected $touches = ['project'];
    
    public function project() { return $this->belongsTo(Project::class, 'projectid'); }
    
    
    public function typeFormData(){
        return $this->hasMany(TypeFormData::class, 'typeformid', 'id')
                    ->orderBy('id', 'ASC');
    }
    
    
    
    public function delete(){
        $this->typeFormData->each(function ($formData) {
            Log::debug('delete() TypeForm each: ' . $formData->id);
            $formData->delete();
        });
            
        Log::debug('delete() TypeForm ' . $this->id);
        $this->typeFormData()->delete();
        
        return parent::delete();
    }
    
}

/*
CREATE TABLE `type_form` (
  `id` 			bigint unsigned NOT NULL AUTO_INCREMENT,
  `userid` 		int NOT NULL,
  `projectid` 	int NOT NULL,
  `libraryid` 	int NOT NULL,
  `cuepointid` 	int NOT NULL,
  `content` 	longtext,
  `name` 		varchar(100) DEFAULT NULL,
  `sendto` 		varchar(100) DEFAULT NULL,
  `created_at` 	timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` 	timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
>>>>>>> 0d6f5c2c18f02c9c7d0a3cb40a1c8218e42ba08f
*/ 