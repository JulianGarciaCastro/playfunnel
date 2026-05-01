<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class AccessControlSeeder extends Seeder
{
    public function run()
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'panel.access',
            'users.impersonate',
            'users.manage_admins',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $superAdminRole = Role::findOrCreate('super_admin', 'web');
        $adminRole = Role::findOrCreate('admin', 'web');

        $superAdminRole->syncPermissions($permissions);
        $adminRole->syncPermissions(['panel.access']);

        $superAdmin = null;
        $configuredEmail = env('SUPER_ADMIN_EMAIL');

        if (! empty($configuredEmail)) {
            $superAdmin = User::where('email', $configuredEmail)->first();
        }

        if (! $superAdmin) {
            $superAdmin = User::query()
                ->where('status', 'ACTIVE')
                ->whereNotNull('email_verified_at')
                ->orderBy('id')
                ->first();
        }

        if ($superAdmin) {
            $superAdmin->assignRole($superAdminRole);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
