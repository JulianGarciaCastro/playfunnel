<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    use HasFactory;
    
    protected $table = 'page_view';
    
    protected $primaryKey = 'idpage_view';
    public $incrementing  = true;
    public $timestamps = false;
    
}
