<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebhookDelivery extends Model
{
    use HasFactory;

    protected $table = 'webhook_deliveries';

    protected $fillable = [
        'webhook_integration_id',
        'trigger',
        'project_id',
        'endpoint_url',
        'status_code',
        'success',
        'request_payload',
        'response_body',
        'error_message',
        'sent_at',
    ];

    protected $casts = [
        'success' => 'boolean',
        'sent_at' => 'datetime',
    ];
}
