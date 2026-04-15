<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        Permission::query()
            ->whereIn('code', ['product.view', 'product.create', 'product.update', 'product.delete'])
            ->delete();

        $rows = [
            ['module' => 'dashboard', 'name' => 'Lihat dashboard admin', 'code' => 'dashboard.view', 'sort_order' => 10],
            ['module' => 'project', 'name' => 'Lihat proyek', 'code' => 'project.view', 'sort_order' => 20],
            ['module' => 'project', 'name' => 'Buat proyek', 'code' => 'project.create', 'sort_order' => 21],
            ['module' => 'project', 'name' => 'Ubah proyek', 'code' => 'project.update', 'sort_order' => 22],
            ['module' => 'rfq', 'name' => 'Lihat RFQ', 'code' => 'rfq.view', 'sort_order' => 30],
            ['module' => 'rfq', 'name' => 'Buat RFQ', 'code' => 'rfq.create', 'sort_order' => 31],
            ['module' => 'rfq', 'name' => 'Ubah RFQ', 'code' => 'rfq.update', 'sort_order' => 32],
            ['module' => 'rfq', 'name' => 'Hapus RFQ', 'code' => 'rfq.delete', 'sort_order' => 33],
            ['module' => 'inventory', 'name' => 'Lihat inventory material', 'code' => 'inventory.view', 'sort_order' => 44],
            ['module' => 'inventory', 'name' => 'Buat inventory material', 'code' => 'inventory.create', 'sort_order' => 45],
            ['module' => 'inventory', 'name' => 'Ubah inventory material', 'code' => 'inventory.update', 'sort_order' => 46],
            ['module' => 'inventory', 'name' => 'Hapus inventory material', 'code' => 'inventory.delete', 'sort_order' => 47],
            ['module' => 'client', 'name' => 'Lihat klien', 'code' => 'client.view', 'sort_order' => 50],
            ['module' => 'client', 'name' => 'Ubah klien', 'code' => 'client.update', 'sort_order' => 51],
            ['module' => 'certificate', 'name' => 'Lihat sertifikat', 'code' => 'certificate.view', 'sort_order' => 60],
            ['module' => 'certificate', 'name' => 'Buat sertifikat', 'code' => 'certificate.create', 'sort_order' => 61],
            ['module' => 'certificate', 'name' => 'Ubah sertifikat', 'code' => 'certificate.update', 'sort_order' => 62],
            ['module' => 'settings', 'name' => 'Lihat peran', 'code' => 'role.view', 'sort_order' => 100],
            ['module' => 'settings', 'name' => 'Buat peran', 'code' => 'role.create', 'sort_order' => 101],
            ['module' => 'settings', 'name' => 'Ubah peran & izin', 'code' => 'role.update', 'sort_order' => 102],
            ['module' => 'settings', 'name' => 'Hapus peran', 'code' => 'role.delete', 'sort_order' => 103],
        ];

        foreach ($rows as $row) {
            Permission::updateOrCreate(
                ['code' => $row['code']],
                [
                    'module' => $row['module'],
                    'name' => $row['name'],
                    'description' => null,
                    'sort_order' => $row['sort_order'],
                    'is_active' => true,
                ]
            );
        }
    }
}
