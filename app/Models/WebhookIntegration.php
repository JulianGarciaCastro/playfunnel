<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebhookIntegration extends Model
{
    use HasFactory;

    protected $table = 'webhook_integrations';

    protected $fillable = [
        'user_id',
        'name',
        'endpoint_url',
        'secret',
        'active',
        'triggers',
    ];

    protected $casts = [
        'active' => 'boolean',
        'triggers' => 'array',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'webhook_integration_projects', 'webhook_integration_id', 'project_id');
    }
}
