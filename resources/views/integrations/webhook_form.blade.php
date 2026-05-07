@php
    $enabledTriggers = old('triggers', $integration ? ($integration->triggers ?: []) : []);
    $selectedProjectValues = old('projects', $selectedProjects);
@endphp

<div class="row">
    <div class="col-12 col-xl-7 mb-4">
        <div class="form-group">
            <label for="webhook_name_{{ $formId }}" class="cMain">{{ __('integrations.name') }}</label>
            <input
                type="text"
                name="name"
                id="webhook_name_{{ $formId }}"
                class="form-control"
                value="{{ old('name', $integration ? $integration->name : '') }}"
                placeholder="{{ __('integrations.name_placeholder') }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="endpoint_url_{{ $formId }}" class="cMain">{{ __('integrations.webhook_url') }}</label>
            <input
                type="url"
                name="endpoint_url"
                id="endpoint_url_{{ $formId }}"
                class="form-control"
                placeholder="{{ __('integrations.webhook_url_placeholder') }}"
                value="{{ old('endpoint_url', $integration ? $integration->endpoint_url : '') }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="secret_{{ $formId }}" class="cMain">{{ __('integrations.hmac_secret') }}</label>
            <input
                type="text"
                name="secret"
                id="secret_{{ $formId }}"
                class="form-control"
                placeholder="{{ $integration && $integration->secret ? __('integrations.keep_secret_placeholder') : __('integrations.optional') }}"
            >
            @if ($integration && $integration->secret)
                <small class="form-text text-muted">{{ __('integrations.secret_configured') }}</small>
            @endif
        </div>

        <div class="custom-control custom-switch mt-3">
            <input
                type="checkbox"
                class="custom-control-input"
                id="active_{{ $formId }}"
                name="active"
                value="1"
                {{ old('active', $integration ? $integration->active : false) ? 'checked' : '' }}
            >
            <label class="custom-control-label cMain" for="active_{{ $formId }}">{{ __('integrations.enable_webhooks') }}</label>
        </div>
    </div>

    <div class="col-12 col-xl-5 mb-4">
        <div class="d-flex align-items-center mb-3">
            <i class="fas fa-tasks cMain mr-2"></i>
            <h4 class="h6 cMain mb-0">{{ __('integrations.triggers') }}</h4>
        </div>

        @foreach ($availableTriggers as $trigger => $label)
            <div class="custom-control custom-checkbox mb-3">
                <input
                    type="checkbox"
                    class="custom-control-input"
                    id="trigger_{{ $formId }}_{{ $loop->index }}"
                    name="triggers[]"
                    value="{{ $trigger }}"
                    {{ in_array($trigger, $enabledTriggers, true) ? 'checked' : '' }}
                >
                <label class="custom-control-label cMain" for="trigger_{{ $formId }}_{{ $loop->index }}">
                    <strong>{{ $trigger }}</strong>
                    <span class="d-block text-muted">{{ __($label) }}</span>
                </label>
            </div>
        @endforeach
    </div>
</div>

<div class="mb-4">
    <div class="d-flex align-items-center mb-3">
        <i class="fas fa-th-large cMain mr-2"></i>
        <h4 class="h6 cMain mb-0">{{ __('integrations.associated_projects') }}</h4>
    </div>

    <div class="row">
        @forelse ($projects as $project)
            @if ($project->project_status_id == 3)
                @continue
            @endif
            <div class="col-12 col-md-6 col-xl-4 mb-2">
                <div class="custom-control custom-checkbox">
                    <input
                        type="checkbox"
                        class="custom-control-input"
                        id="project_{{ $formId }}_{{ $project->id }}"
                        name="projects[]"
                        value="{{ $project->id }}"
                        {{ in_array((int) $project->id, array_map('intval', $selectedProjectValues), true) ? 'checked' : '' }}
                    >
                    <label class="custom-control-label cMain" for="project_{{ $formId }}_{{ $project->id }}">{{ $project->name }}</label>
                </div>
            </div>
        @empty
            <div class="col-12 text-muted">{{ __('integrations.no_projects') }}</div>
        @endforelse
    </div>
</div>

<div class="d-flex justify-content-end">
    <button type="submit" class="btn-square px-4 bg-Main cWhite">{{ $submitText }}</button>
</div>
