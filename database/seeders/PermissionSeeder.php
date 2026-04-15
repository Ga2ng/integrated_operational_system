<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['module' => 'dashboard', 'name' => 'Lihat dashboard admin', 'code' => 'dashboard.view', 'sort_order' => 10],
            ['module' => 'project', 'name' => 'Lihat proyek', 'code' => 'project.view', 'sort_order' => 20],
            ['module' => 'project', 'name' => 'Buat proyek', 'code' => 'project.create', 'sort_order' => 21],
            ['module' => 'project', 'name' => 'Ubah proyek', 'code' => 'project.update', 'sort_order' => 22],
            ['module' => 'rfq', 'name' => 'Lihat RFQ', 'code' => 'rfq.view', 'sort_order' => 30],
            ['module' => 'rfq', 'name' => 'Buat RFQ', 'code' => 'rfq.create', 'sort_order' => 31],
            ['module' => 'rfq', 'name' => 'Ubah RFQ', 'code' => 'rfq.update', 'sort_order' => 32],
            ['module' => 'rfq', 'name' => 'Hapus RFQ', 'code' => 'rfq.delete', 'sort_order' => 33],
            ['module' => 'product', 'name' => 'Lihat produk', 'code' => 'product.view', 'sort_order' => 40],
            ['module' => 'product', 'name' => 'Buat produk', 'code' => 'product.create', 'sort_order' => 41],
            ['module' => 'product', 'name' => 'Ubah produk', 'code' => 'product.update', 'sort_order' => 42],
            ['module' => 'product', 'name' => 'Hapus produk', 'code' => 'product.delete', 'sort_order' => 43],
            ['module' => 'client', 'name' => 'Lihat klien', 'code' => 'client.view', 'sort_order' => 50],
            ['module' => 'client', 'name' => 'Ubah klien', 'code' => 'client.update', 'sort_order' => 51],
            ['module' => 'certificate', 'name' => 'Lihat sertifikat', 'code' => 'certificate.view', 'sort_order' => 60],
            ['module' => 'certificate', 'name' => 'Buat sertifikat', 'code' => 'certificate.create', 'sort_order' => 61],
            ['module' => 'certificate', 'name' => 'Ubah sertifikat', 'code' => 'certificate.update', 'sort_order' => 62],
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
