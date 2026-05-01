<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrmCustomField extends Model
{
    use HasFactory;

    protected $table = 'crm_custom_fields';

    protected $fillable = [
        'userid',
        'name',
        'slug',
        'type',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function values()
    {
        return $this->hasMany(CrmCustomFieldValue::class, 'crm_custom_field_id');
    }
}
