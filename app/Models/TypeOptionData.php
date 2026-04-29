<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Project;

class TypeOptionData extends Model
{
    use HasFactory;
    
    protected $table = 'type_option_data';
    
    protected $touches = ['project'];
    
    public function project() { return $this->belongsTo(Project::class, 'projectid'); }
}


/*
CREATE TABLE `type_option_data` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `projectid` int(11) NOT NULL,
  `projectlibraryid` int(11) NOT NULL,
  `libraryid` int(11) NOT NULL,
  `cuepointid` int(11) NOT NULL,
  `typeoptionid` int(11) NOT NULL,
  `position` int(11) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `goto` varchar(254) DEFAULT NULL,
  `options` varchar(254) DEFAULT NULL,
  `text` varchar(500) DEFAULT NULL,
  `image_yorn` varchar(254) DEFAULT NULL,
  `image_url` varchar(254) DEFAULT NULL,
  `class_options` varchar(254) DEFAULT NULL,
  `style_options` varchar(254) DEFAULT NULL,
  `title` varchar(254) DEFAULT NULL,
  `content` longtext,
  `uuid` varchar(128) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;
*/