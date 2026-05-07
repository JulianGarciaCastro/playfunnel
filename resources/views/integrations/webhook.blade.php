<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ asset('css/Style.css') }}">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <title>{{ __('integrations.title') }}</title>
        <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
        <script src="https://kit.fontawesome.com/0190c3506a.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-white">
        @include('nav_bar')

        <div class="container-fluid m-0 p-0 vh-100">
            <section class="projects row col-12 mx-0 p-0 w-100">
                <x-side-nav/>

                <div class="mainContainer col row p-0 m-0">
                    <div class="main w-100 m-0 p-0 p-lg-5 p-2">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h2 class="font-weight-light cMain h3 mb-1">{{ __('integrations.integrations') }}</h2>
                                <p class="mb-0 c05">{{ __('integrations.webhooks_by_project') }}</p>
                            </div>
                            <span class="badge badge-info px-3 py-2">{{ $integrations->count() }} {{ __('integrations.configured') }}</span>
                        </div>

                        @if (session('webhook_success'))
                            <div class="alert alert-success mt-3" role="alert">{{ session('webhook_success') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger mt-3" role="alert">
                                <ul class="mb-0 pl-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="bg-06 br-r1 p-4 mt-4 mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-plus-circle cMain mr-2"></i>
                                <h3 class="h5 cMain mb-0">{{ __('integrations.new_webhook') }}</h3>
                            </div>

                            <form action="{{ route('integrations.webhook.store') }}" method="post">
                                @csrf
                                @include('integrations.webhook_form', [
                                    'formId' => 'new',
                                    'integration' => null,
                                    'selectedProjects' => [],
                                    'submitText' => __('integrations.create_webhook'),
                                ])
                            </form>
                        </div>

                        @forelse ($integrations as $integration)
                            @php
                                $selectedProjects = $integration->projects->pluck('id')->map(function ($id) {
                                    return (int) $id;
                                })->all();
                            @endphp
                            <div class="bg-06 br-r1 p-4 mb-4">
                                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-link cMain mr-2"></i>
                                        <h3 class="h5 cMain mb-0">{{ $integration->name }}</h3>
                                    </div>
                                    <span class="badge {{ $integration->active ? 'badge-success' : 'badge-secondary' }} px-3 py-2">
                                        {{ $integration->active ? __('integrations.active') : __('integrations.inactive') }}
                                    </span>
                                </div>

                                <form action="{{ route('integrations.webhook.update', $integration->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    @include('integrations.webhook_form', [
                                        'formId' => 'edit_' . $integration->id,
                                        'integration' => $integration,
                                        'selectedProjects' => $selectedProjects,
                                        'submitText' => __('integrations.save_changes'),
                                    ])
                                </form>

                                <form action="{{ route('integrations.webhook.destroy', $integration->id) }}" method="post" class="mt-2 text-right">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger p-0" onclick="return confirm('{{ __('integrations.confirm_delete_webhook') }}')">
                                        <i class="fas fa-trash-alt mr-1"></i>{{ __('integrations.delete_webhook') }}
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="alert alert-info">{{ __('integrations.no_webhooks') }}</div>
                        @endforelse

                        <div class="bg-06 br-r1 p-4 mb-5">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-history cMain mr-2"></i>
                                <h3 class="h5 cMain mb-0">{{ __('integrations.last_deliveries') }}</h3>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-sm bg-white">
                                    <thead>
                                        <tr>
                                            <th>{{ __('integrations.date') }}</th>
                                            <th>{{ __('integrations.webhook') }}</th>
                                            <th>{{ __('integrations.triggers') }}</th>
                                            <th>{{ __('integrations.project') }}</th>
                                            <th>{{ __('integrations.status') }}</th>
                                            <th>HTTP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($deliveries as $delivery)
                                            <tr>
                                                <td>{{ optional($delivery->created_at)->format('Y-m-d H:i:s') }}</td>
                                                <td>{{ $delivery->webhook_integration_id }}</td>
                                                <td>{{ $delivery->trigger }}</td>
                                                <td>{{ $delivery->project_id }}</td>
                                                <td>{{ $delivery->success ? __('integrations.ok') : __('integrations.error') }}</td>
                                                <td>{{ $delivery->status_code ?: '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-muted">{{ __('integrations.no_deliveries') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    </body>
</html>
