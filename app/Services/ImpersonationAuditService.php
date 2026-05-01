<?php

namespace App\Services;

use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ImpersonationAuditService
{
    public static function logStart(Request $request, User $impersonator, User $target, string $reason): array
    {
        $startedAt = CarbonImmutable::now();

        $context = array_merge(self::requestContext($request), [
            'event' => 'impersonation.start',
            'impersonator_id' => $impersonator->id,
            'impersonator_email' => $impersonator->email,
            'impersonated_id' => $target->id,
            'impersonated_email' => $target->email,
            'reason' => $reason,
            'started_at' => $startedAt->toIso8601String(),
        ]);

        Log::channel('impersonation')->info('impersonation.start', $context);

        return [
            'reason' => $reason,
            'started_at' => $startedAt->toIso8601String(),
            'impersonator_id' => $impersonator->id,
            'impersonator_email' => $impersonator->email,
            'impersonated_id' => $target->id,
            'impersonated_email' => $target->email,
        ];
    }

    public static function logStop(Request $request, ?User $impersonator, User $impersonatedUser, array $auditData = []): void
    {
        $endedAt = CarbonImmutable::now();
        $startedAt = null;
        $durationSeconds = null;

        if (! empty($auditData['started_at'])) {
            $startedAt = CarbonImmutable::parse($auditData['started_at']);
            $durationSeconds = $startedAt->diffInSeconds($endedAt);
        }

        Log::channel('impersonation')->info('impersonation.stop', array_merge(self::requestContext($request), [
            'event' => 'impersonation.stop',
            'impersonator_id' => $impersonator?->id ?? $auditData['impersonator_id'] ?? null,
            'impersonator_email' => $impersonator?->email ?? $auditData['impersonator_email'] ?? null,
            'impersonated_id' => $impersonatedUser->id,
            'impersonated_email' => $impersonatedUser->email,
            'reason' => $auditData['reason'] ?? null,
            'started_at' => $startedAt?->toIso8601String() ?? $auditData['started_at'] ?? null,
            'ended_at' => $endedAt->toIso8601String(),
            'duration_seconds' => $durationSeconds,
        ]));
    }

    public static function logFailure(Request $request, ?User $actor, ?User $target, string $failure, ?string $reason = null): void
    {
        Log::channel('impersonation')->warning('impersonation.failure', array_merge(self::requestContext($request), [
            'event' => 'impersonation.failure',
            'actor_id' => $actor?->id,
            'actor_email' => $actor?->email,
            'target_id' => $target?->id,
            'target_email' => $target?->email,
            'reason' => $reason,
            'failure' => $failure,
            'occurred_at' => CarbonImmutable::now()->toIso8601String(),
        ]));
    }

    protected static function requestContext(Request $request): array
    {
        return [
            'ip' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
            'session_id' => $request->session()->getId(),
            'path' => $request->path(),
            'method' => $request->method(),
        ];
    }
}
