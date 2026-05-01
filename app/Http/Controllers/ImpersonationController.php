<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ImpersonationAuditService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ImpersonationController extends Controller
{
    public function leave(Request $request): RedirectResponse
    {
        $impersonatedUser = $request->user();

        if (! app()->bound('impersonate') || ! app('impersonate')->isImpersonating()) {
            ImpersonationAuditService::logFailure(
                $request,
                $impersonatedUser,
                null,
                'leave_called_without_active_impersonation'
            );

            return redirect()->route('dashboard')->withErrors(__('No hay una impersonación activa.'));
        }

        $impersonatorId = $request->session()->get(config('impersonate.session_key', 'impersonated_by'));
        $impersonator = User::find($impersonatorId);

        $auditData = $request->session()->pull('impersonation.audit', []);

        ImpersonationAuditService::logStop($request, $impersonator, $impersonatedUser, $auditData);

        $impersonatedUser->leaveImpersonation();

        return redirect()->route('dashboard')->with('status', __('Impersonation finalizada correctamente.'));
    }
}
