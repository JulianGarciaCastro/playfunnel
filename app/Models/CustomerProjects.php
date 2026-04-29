<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CustomerProjects extends Model
{
    use HasFactory;

    protected $table = 'customers_projects';

    protected $primaryKey = 'id';
    public $incrementing  = true;
    public $timestamps    = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //'id',
            'customerId',
            'projectId',
            'sessionId',
        ];

     /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];


}
