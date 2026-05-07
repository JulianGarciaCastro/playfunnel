<?php

namespace App\Services;

use App\Models\Project;
use App\Models\WebhookDelivery;
use App\Models\WebhookIntegration;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class WebhookDispatcher
{
    public const TRIGGERS = [
        'lead.created' => 'integrations.trigger_lead_created',
        'interaction.created' => 'integrations.trigger_interaction_created',
        'funnel.completed' => 'integrations.trigger_funnel_completed',
        'tag.assigned' => 'integrations.trigger_tag_assigned',
    ];

    public function dispatch($trigger, Project $project = null, array $payload = [])
    {
        if (!$project || !$project->user_id || !array_key_exists($trigger, self::TRIGGERS)) {
            return;
        }

        $integrations = WebhookIntegration::where('user_id', $project->user_id)
            ->where('active', true)
            ->whereNotNull('endpoint_url')
            ->whereHas('projects', function ($query) use ($project) {
                $query->where('project.id', $project->id);
            })
            ->get();

        foreach ($integrations as $integration) {
            $enabledTriggers = is_array($integration->triggers) ? $integration->triggers : [];
            if (!in_array($trigger, $enabledTriggers, true)) {
                continue;
            }

            $this->send($integration, $trigger, $project, $payload);
        }
    }

    protected function send(WebhookIntegration $integration, $trigger, Project $project, array $payload)
    {
        $body = [
            'event' => $trigger,
            'event_label' => __(self::TRIGGERS[$trigger]),
            'sent_at' => Carbon::now()->toIso8601String(),
            'project' => [
                'id' => $project->id,
                'name' => $project->name,
                'status_id' => $project->project_status_id,
            ],
            'data' => $payload,
        ];

        $jsonPayload = json_encode($body);
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'User-Agent' => 'PlayFunnel-Webhooks/1.0',
            'X-PlayFunnel-Event' => $trigger,
        ];

        if ($integration->secret) {
            $headers['X-PlayFunnel-Signature'] = hash_hmac('sha256', $jsonPayload, $integration->secret);
        }

        $delivery = WebhookDelivery::create([
            'webhook_integration_id' => $integration->id,
            'trigger' => $trigger,
            'project_id' => $project->id,
            'endpoint_url' => $integration->endpoint_url,
            'request_payload' => $jsonPayload,
            'sent_at' => Carbon::now(),
        ]);

        try {
            $response = (new Client(['timeout' => 5, 'connect_timeout' => 3]))->post($integration->endpoint_url, [
                'headers' => $headers,
                'body' => $jsonPayload,
                'http_errors' => false,
            ]);

            $statusCode = $response->getStatusCode();
            $delivery->status_code = $statusCode;
            $delivery->success = $statusCode >= 200 && $statusCode < 300;
            $delivery->response_body = substr((string) $response->getBody(), 0, 5000);
            $delivery->save();
        } catch (\Throwable $th) {
            $delivery->success = false;
            $delivery->error_message = substr($th->getMessage(), 0, 5000);
            $delivery->save();

            Log::warning('Webhook delivery failed: ' . $th->getMessage(), [
                'webhook_integration_id' => $integration->id,
                'trigger' => $trigger,
                'project_id' => $project->id,
            ]);
        }
    }
}
