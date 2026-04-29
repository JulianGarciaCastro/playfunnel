<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
//use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Notifications\Notifiable;

class ProjectStatus extends Model
{
    protected $table = 'project_status';

    protected $primaryKey = 'id';
    public $incrementing  = true;
    protected $keyType    = 'int';

/*
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';
*/


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     *
    protected $hidden = [
        'password',
        'remember_token',
    ];*/

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     *
    protected $casts = [
        'creation_date' => 'datetime',
    ];*/
}
