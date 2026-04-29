<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Project;


class TypeFormData extends Model
{
    use HasFactory;
    
    protected $table = 'type_form_data';
    
    protected $touches = ['project'];
    
    public function project() { return $this->belongsTo(Project::class, 'projectid'); }
}


/*
CREATE TABLE `type_form_data` (
  `id` 				bigint unsigned NOT NULL AUTO_INCREMENT,
  `projectid` 		int NOT NULL,
  `libraryid` 		int NOT NULL,
  `cuepointid` 		int NOT NULL,
  `typeformid` 		int NOT NULL,
  `name` 			varchar(100) DEFAULT NULL,
  `email` 			varchar(254) DEFAULT NULL,
  `phone` 			varchar(254) DEFAULT NULL,
  `title` 			varchar(254) DEFAULT NULL,
  `comments` 		longtext,
  `birthday` 		timestamp DEFAULT NULL,
  `postalcode` 		varchar(25) DEFAULT NULL,
  `created_at` 		timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` 		timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
*/