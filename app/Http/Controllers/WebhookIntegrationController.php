<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\WebhookDelivery;
use App\Models\WebhookIntegration;
use App\Services\WebhookDispatcher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class WebhookIntegrationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $projects = Project::where('user_id', Auth::id())->orderBy('name', 'asc')->get();
        $integrations = WebhookIntegration::where('user_id', Auth::id())
            ->with('projects')
            ->orderBy('created_at', 'desc')
            ->get();
        $deliveries = WebhookDelivery::whereIn('webhook_integration_id', $integrations->pluck('id'))
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        $availableTriggers = WebhookDispatcher::TRIGGERS;

        return view('integrations.webhook', compact('user', 'projects', 'integrations', 'deliveries', 'availableTriggers'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateWebhook($request);

        $integration = WebhookIntegration::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'endpoint_url' => $validated['endpoint_url'],
            'secret' => $validated['secret'] ?? null,
            'active' => $request->boolean('active'),
            'triggers' => $validated['triggers'] ?? [],
        ]);

        $integration->projects()->sync($validated['projects'] ?? []);

        return Redirect::route('integrations.webhook')->with('webhook_success', __('integrations.created_success'));
    }

    public function update(Request $request, $id)
    {
        $integration = WebhookIntegration::where('user_id', Auth::id())->findOrFail($id);
        $validated = $this->validateWebhook($request);

        $integration->name = $validated['name'];
        $integration->endpoint_url = $validated['endpoint_url'];
        if ($request->filled('secret')) {
            $integration->secret = $validated['secret'];
        }
        $integration->active = $request->boolean('active');
        $integration->triggers = $validated['triggers'] ?? [];
        $integration->save();

        $integration->projects()->sync($validated['projects'] ?? []);

        return Redirect::route('integrations.webhook')->with('webhook_success', __('integrations.updated_success'));
    }

    public function destroy($id)
    {
        $integration = WebhookIntegration::where('user_id', Auth::id())->findOrFail($id);
        $integration->projects()->detach();
        $integration->delete();

        return Redirect::route('integrations.webhook')->with('webhook_success', __('integrations.deleted_success'));
    }

    protected function validateWebhook(Request $request)
    {
        $availableTriggers = array_keys(WebhookDispatcher::TRIGGERS);
        $projectIds = Project::where('user_id', Auth::id())->pluck('id')->map(function ($id) {
            return (string) $id;
        })->all();

        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'endpoint_url' => ['required', 'url', 'max:1000'],
            'secret' => ['nullable', 'string', 'max:255'],
            'active' => ['nullable', 'boolean'],
            'triggers' => ['nullable', 'array'],
            'triggers.*' => ['string', Rule::in($availableTriggers)],
            'projects' => ['nullable', 'array'],
            'projects.*' => ['string', Rule::in($projectIds)],
        ]);
    }
}
