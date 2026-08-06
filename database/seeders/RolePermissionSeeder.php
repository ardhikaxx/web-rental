<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'dashboard.view',
            'users.manage',
            'roles.manage',
            'fleets.manage',
            'drivers.manage',
            'bookings.manage',
            'bookings.approve',
            'payments.manage',
            'payments.verify',
            'maintenances.manage',
            'tours.manage',
            'travel.manage',
            'wedding.manage',
            'promos.manage',
            'cms.manage',
            'reports.manage',
            'reports.export',
            'settings.manage',
            'logs.view',
            'customers.manage',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        $roles = [
            'super_admin' => $permissions,
            'owner' => ['dashboard.view', 'bookings.manage', 'bookings.approve', 'payments.manage',
                'payments.verify', 'reports.manage', 'reports.export', 'logs.view', 'fleets.manage',
                'drivers.manage', 'customers.manage'],
            'admin_operasional' => ['dashboard.view', 'fleets.manage', 'drivers.manage',
                'bookings.manage', 'bookings.approve', 'maintenances.manage', 'tours.manage',
                'travel.manage', 'wedding.manage', 'customers.manage'],
            'customer_service' => ['dashboard.view', 'bookings.manage', 'bookings.approve',
                'payments.manage', 'customers.manage', 'fleets.manage'],
            'driver' => ['dashboard.view'],
            'tour_leader' => ['dashboard.view', 'tours.manage', 'bookings.manage', 'customers.manage'],
            'keuangan' => ['dashboard.view', 'payments.manage', 'payments.verify',
                'reports.manage', 'reports.export', 'bookings.manage'],
            'marketing' => ['dashboard.view', 'cms.manage', 'promos.manage',
                'reports.manage', 'reports.export'],
            'customer' => [],
        ];

        foreach ($roles as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($perms);
        }
    }
}