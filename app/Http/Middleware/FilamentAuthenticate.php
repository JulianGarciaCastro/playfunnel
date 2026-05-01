<?php

namespace App\Http\Middleware;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Throwable;

class FilamentAuthenticate extends Middleware
{
    protected function authenticate($request, array $guards): void
    {
        $guardName = config('filament.auth.guard');
        try {
            $guard = $this->auth->guard($guardName);

            if (! $guard->check()) {
                $this->unauthenticated($request, [$guardName]);

                return;
            }

            $this->auth->shouldUse($guardName);

            $user = $guard->user();

            if ($user instanceof FilamentUser) {
                if ($user->canAccessFilament()) {
                    return;
                }

                throw new AuthenticationException('Unauthorized Filament access.', [$guardName], route('login'));
            }

            if (config('app.env') === 'local') {
                return;
            }

            throw new AuthenticationException('Unauthorized Filament access.', [$guardName], route('login'));
        } catch (Throwable $exception) {
            report($exception);
            throw new AuthenticationException('Unable to validate admin access.', [$guardName], route('login'));
        }
    }

    protected function redirectTo($request): ?string
    {
        if (! $request->expectsJson()) {
            return route('login');
        }

        return null;
    }
}
