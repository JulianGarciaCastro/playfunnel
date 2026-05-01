<?php

namespace Tests\Feature;

use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\User;
use App\Services\ImpersonationAuditService;
use Database\Seeders\AccessControlSeeder;
use Filament\Forms\Components\Textarea;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Livewire\Livewire;
use Mockery;
use Tests\TestCase;

class AdminImpersonationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_without_panel_access_cannot_access_admin_panel()
    {
        $this->seed(AccessControlSeeder::class);

        $user = User::factory()->create([
            'status' => 'ACTIVE',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(403);
    }

    public function test_admin_without_impersonation_permission_cannot_impersonate()
    {
        $this->seed(AccessControlSeeder::class);

        $admin = User::factory()->create([
            'status' => 'ACTIVE',
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        $this->assertFalse($admin->canImpersonate());
    }

    public function test_admin_with_impersonation_permission_can_impersonate_and_leave()
    {
        $this->seed(AccessControlSeeder::class);

        $admin = User::factory()->create([
            'status' => 'ACTIVE',
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');
        $admin->givePermissionTo('users.impersonate');

        $target = User::factory()->create([
            'status' => 'ACTIVE',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($admin);

        $admin->impersonate($target);

        $this->assertTrue(app('impersonate')->isImpersonating());
        $this->assertSame($target->id, auth()->id());

        $response = $this->post(route('impersonation.leave'));

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_nested_impersonation_is_blocked_while_impersonating()
    {
        $this->seed(AccessControlSeeder::class);

        $admin = User::factory()->create([
            'status' => 'ACTIVE',
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');
        $admin->givePermissionTo('users.impersonate');

        $target = User::factory()->create([
            'status' => 'ACTIVE',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($admin);
        $admin->impersonate($target);

        $this->assertFalse(auth()->user()->canImpersonate());
    }

    public function test_panel_access_requires_active_status_and_verified_email()
    {
        $this->seed(AccessControlSeeder::class);

        $inactiveAdmin = User::factory()->create([
            'status' => 'INACTIVE',
            'email_verified_at' => now(),
        ]);
        $inactiveAdmin->assignRole('admin');

        $unverifiedAdmin = User::factory()->create([
            'status' => 'ACTIVE',
            'email_verified_at' => null,
        ]);
        $unverifiedAdmin->assignRole('admin');

        $activeAdmin = User::factory()->create([
            'status' => 'ACTIVE',
            'email_verified_at' => now(),
        ]);
        $activeAdmin->assignRole('admin');

        $this->assertFalse($inactiveAdmin->canAccessFilament());
        $this->assertFalse($unverifiedAdmin->canAccessFilament());
        $this->assertTrue($activeAdmin->canAccessFilament());
    }

    public function test_impersonation_action_reason_is_optional()
    {
        $this->seed(AccessControlSeeder::class);

        $superAdmin = User::factory()->create([
            'status' => 'ACTIVE',
            'email_verified_at' => now(),
        ]);
        $superAdmin->assignRole('super_admin');

        $livewire = Livewire::actingAs($superAdmin)->test(ListUsers::class);
        $actions = $livewire->instance()->getCachedTableActions();

        $this->assertArrayHasKey('impersonate', $actions);

        $reasonField = collect($actions['impersonate']->getFormSchema())
            ->first(fn ($component) => $component instanceof Textarea && $component->getName() === 'reason');

        $this->assertInstanceOf(Textarea::class, $reasonField);
        $this->assertFalse($reasonField->isRequired());
        $this->assertNull($reasonField->getMinLength());
        $this->assertSame(500, $reasonField->getMaxLength());
    }

    public function test_impersonation_action_is_hidden_for_self_target_and_visible_for_other_user()
    {
        $this->seed(AccessControlSeeder::class);

        $superAdmin = User::factory()->create([
            'status' => 'ACTIVE',
            'email_verified_at' => now(),
        ]);
        $superAdmin->assignRole('super_admin');

        $target = User::factory()->create([
            'status' => 'ACTIVE',
            'email_verified_at' => now(),
        ]);

        $livewire = Livewire::actingAs($superAdmin)->test(ListUsers::class);
        $actions = $livewire->instance()->getCachedTableActions();

        $this->assertArrayHasKey('impersonate', $actions);

        $impersonateAction = $actions['impersonate'];

        $impersonateAction->record($superAdmin);
        $this->assertTrue($impersonateAction->isHidden());

        $impersonateAction->record($target);
        $this->assertFalse($impersonateAction->isHidden());
    }

    public function test_impersonation_audit_logs_include_required_fields_for_start_stop_and_failure()
    {
        $this->seed(AccessControlSeeder::class);

        $impersonator = User::factory()->create([
            'status' => 'ACTIVE',
            'email_verified_at' => now(),
        ]);

        $target = User::factory()->create([
            'status' => 'ACTIVE',
            'email_verified_at' => now(),
        ]);

        $request = Request::create('/admin/users', 'POST', [], [], [], [
            'REMOTE_ADDR' => '127.0.0.1',
            'HTTP_USER_AGENT' => 'PHPUnit Audit Agent',
        ]);

        $session = app('session')->driver();
        $session->start();
        $request->setLaravelSession($session);

        $logger = Mockery::mock();

        Log::shouldReceive('channel')->times(3)->with('impersonation')->andReturn($logger);

        $logger->shouldReceive('info')->once()->with('impersonation.start', Mockery::on(function (array $context) use ($impersonator, $target): bool {
            return ($context['event'] ?? null) === 'impersonation.start'
                && ($context['impersonator_id'] ?? null) === $impersonator->id
                && ($context['impersonator_email'] ?? null) === $impersonator->email
                && ($context['impersonated_id'] ?? null) === $target->id
                && ($context['impersonated_email'] ?? null) === $target->email
                && ($context['reason'] ?? null) === 'Soporte de incidencia'
                && filled($context['started_at'] ?? null)
                && filled($context['ip'] ?? null)
                && filled($context['user_agent'] ?? null)
                && filled($context['session_id'] ?? null)
                && filled($context['path'] ?? null)
                && filled($context['method'] ?? null);
        }));

        $logger->shouldReceive('info')->once()->with('impersonation.stop', Mockery::on(function (array $context) use ($impersonator, $target): bool {
            return ($context['event'] ?? null) === 'impersonation.stop'
                && ($context['impersonator_id'] ?? null) === $impersonator->id
                && ($context['impersonator_email'] ?? null) === $impersonator->email
                && ($context['impersonated_id'] ?? null) === $target->id
                && ($context['impersonated_email'] ?? null) === $target->email
                && ($context['reason'] ?? null) === 'Soporte de incidencia'
                && filled($context['started_at'] ?? null)
                && filled($context['ended_at'] ?? null)
                && array_key_exists('duration_seconds', $context)
                && filled($context['ip'] ?? null)
                && filled($context['user_agent'] ?? null)
                && filled($context['session_id'] ?? null)
                && filled($context['path'] ?? null)
                && filled($context['method'] ?? null);
        }));

        $logger->shouldReceive('warning')->once()->with('impersonation.failure', Mockery::on(function (array $context) use ($impersonator, $target): bool {
            return ($context['event'] ?? null) === 'impersonation.failure'
                && ($context['actor_id'] ?? null) === $impersonator->id
                && ($context['actor_email'] ?? null) === $impersonator->email
                && ($context['target_id'] ?? null) === $target->id
                && ($context['target_email'] ?? null) === $target->email
                && ($context['reason'] ?? null) === 'Soporte de incidencia'
                && ($context['failure'] ?? null) === 'self_impersonation_blocked'
                && filled($context['occurred_at'] ?? null)
                && filled($context['ip'] ?? null)
                && filled($context['user_agent'] ?? null)
                && filled($context['session_id'] ?? null)
                && filled($context['path'] ?? null)
                && filled($context['method'] ?? null);
        }));

        $auditData = ImpersonationAuditService::logStart($request, $impersonator, $target, 'Soporte de incidencia');
        ImpersonationAuditService::logStop($request, $impersonator, $target, $auditData);
        ImpersonationAuditService::logFailure($request, $impersonator, $target, 'self_impersonation_blocked', 'Soporte de incidencia');
    }

    public function test_second_admin_can_be_created_and_granted_impersonation_permission()
    {
        $this->seed(AccessControlSeeder::class);

        $superAdmin = User::factory()->create([
            'status' => 'ACTIVE',
            'email_verified_at' => now(),
        ]);
        $superAdmin->assignRole('super_admin');

        $secondAdmin = User::factory()->create([
            'status' => 'ACTIVE',
            'email_verified_at' => now(),
        ]);
        $secondAdmin->assignRole('admin');

        $this->assertTrue($superAdmin->hasPermissionSafely('users.manage_admins'));

        $this->assertTrue($secondAdmin->hasPermissionSafely('panel.access'));
        $this->assertFalse($secondAdmin->hasPermissionSafely('users.manage_admins'));
        $this->assertTrue($secondAdmin->canAccessFilament());
        $this->assertFalse($secondAdmin->canImpersonate());

        $secondAdmin->givePermissionTo('users.impersonate');

        $this->assertTrue($secondAdmin->canImpersonate());
    }
}

