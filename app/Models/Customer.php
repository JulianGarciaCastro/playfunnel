<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'crm';

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
            'name',
            'email',
            'tel',
            'address',
            'birthday',
            'city',
            'state',
            'cp',
            'country',
            'projects',
            'interactions',
        ];

     /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


}
