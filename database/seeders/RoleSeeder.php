<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Super Admin', 'code' => 'super_admin', 'description' => 'Akses penuh (bypass gate).', 'sort_order' => 1],
            ['name' => 'Admin', 'code' => 'admin', 'description' => 'Operasional sistem.', 'sort_order' => 2],
            ['name' => 'Marketing', 'code' => 'marketing', 'description' => 'RFQ dan monitoring inventory.', 'sort_order' => 3],
            ['name' => 'Customer', 'code' => 'customer', 'description' => 'Klien terdaftar.', 'sort_order' => 10],
        ];

        foreach ($roles as $r) {
            Role::updateOrCreate(
                ['code' => $r['code']],
                [
                    'name' => $r['name'],
                    'description' => $r['description'],
                    'sort_order' => $r['sort_order'],
                    'is_active' => true,
                ]
            );
        }

        $allCodes = Permission::query()->pluck('code')->all();

        $adminCodes = $allCodes;

        $marketingCodes = [
            'dashboard.view',
            'inventory.view',
            'rfq.view', 'rfq.create', 'rfq.update', 'rfq.delete',
        ];

        Role::where('code', 'super_admin')->first()?->permissions()->sync(
            Permission::whereIn('code', $allCodes)->pluck('id')
        );

        Role::where('code', 'admin')->first()?->permissions()->sync(
            Permission::whereIn('code', $adminCodes)->pluck('id')
        );

        Role::where('code', 'marketing')->first()?->permissions()->sync(
            Permission::whereIn('code', $marketingCodes)->pluck('id')
        );

        Role::where('code', 'customer')->first()?->permissions()->sync([]);
    }
}
