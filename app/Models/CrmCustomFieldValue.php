<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrmCustomFieldValue extends Model
{
    use HasFactory;

    protected $table = 'crm_custom_field_values';

    protected $fillable = [
        'customer_id',
        'crm_custom_field_id',
        'value',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function customField()
    {
        return $this->belongsTo(CrmCustomField::class, 'crm_custom_field_id');
    }
}
