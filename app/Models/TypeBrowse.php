<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Project;


class TypeBrowse extends Model
{
    use HasFactory;
    
    protected $table = 'type_browse';
    
    protected $touches = ['project'];
    
    public function project() { return $this->belongsTo(Project::class, 'projectid'); }
    
}


/*
CREATE TABLE `type_browse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `projectid` int(11) NOT NULL,
  `libraryid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `cuepointid` int(11) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `goto` varchar(254) DEFAULT NULL,
  `options` varchar(254) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
*/