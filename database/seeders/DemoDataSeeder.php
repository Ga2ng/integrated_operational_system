<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\ClientProfile;
use App\Models\MaterialInventory;
use App\Models\Project;
use App\Models\Rfq;
use App\Models\RfqMaterialItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();

        $customer = User::where('email', 'customer@example.com')->first();
        if ($customer && ! $customer->clientProfile) {
            ClientProfile::create([
                'user_id' => $customer->id,
                'phone' => '081234567890',
                'address' => 'Jl. Contoh No. 1',
                'company_name' => null,
                'category' => 'individu',
                'status' => 'active',
                'created_by' => $admin?->id,
                'updated_by' => $admin?->id,
            ]);
        }

        $materialA = MaterialInventory::updateOrCreate(
            ['code' => 'MAT-CABLE-001'],
            [
                'name' => 'Kabel NYY 3x2.5',
                'specification' => 'Material kabel listrik untuk instalasi indoor',
                'uom' => 'meter',
                'current_stock' => 120,
                'minimum_stock' => 100,
                'unit_cost' => 25000,
                'is_active' => true,
                'created_by' => $admin?->id,
                'updated_by' => $admin?->id,
            ]
        );

        $materialB = MaterialInventory::updateOrCreate(
            ['code' => 'MAT-PIPE-001'],
            [
                'name' => 'Pipa Conduit PVC',
                'specification' => 'Pipa pelindung kabel',
                'uom' => 'batang',
                'current_stock' => 50,
                'minimum_stock' => 60,
                'unit_cost' => 18000,
                'is_active' => true,
                'created_by' => $admin?->id,
                'updated_by' => $admin?->id,
            ]
        );

        $project = Project::firstOrCreate(
            ['name' => 'Proyek Demo — Instalasi A'],
            [
                'scope_of_work' => 'Instalasi dan commissioning peralatan.',
                'start_date' => now()->subDays(10),
                'end_date' => now()->addMonths(2),
                'manager_user_id' => $admin?->id,
                'status' => 'in_progress',
                'notes' => 'Contoh data untuk skripsi.',
                'created_by' => $admin?->id,
                'updated_by' => $admin?->id,
            ]
        );

        if ($customer) {
            $rfq = Rfq::firstOrCreate(
                [
                    'client_user_id' => $customer->id,
                    'request_title' => 'Pengadaan material instalasi panel',
                    'transaction_date' => now()->toDateString(),
                ],
                [
                    'quoted_amount' => 1500000,
                    'status' => 'pending',
                    'notes' => 'Permintaan penawaran demo.',
                    'created_by' => $customer->id,
                    'updated_by' => $admin?->id,
                ]
            );

            RfqMaterialItem::updateOrCreate(
                [
                    'rfq_id' => $rfq->id,
                    'material_inventory_id' => $materialA->id,
                ],
                [
                    'qty_needed' => 30,
                    'estimated_cost' => 30 * 25000,
                ]
            );

            RfqMaterialItem::updateOrCreate(
                [
                    'rfq_id' => $rfq->id,
                    'material_inventory_id' => $materialB->id,
                ],
                [
                    'qty_needed' => 20,
                    'estimated_cost' => 20 * 18000,
                ]
            );

            Certificate::updateOrCreate(
                ['validation_code' => 'DEMO-CERT-0001'],
                [
                    'participant_user_id' => $customer->id,
                    'project_id' => $project->id,
                    'issued_at' => now()->toDateString(),
                    'valid_until' => now()->addYear()->toDateString(),
                    'document_path' => null,
                    'created_by' => $admin?->id,
                    'updated_by' => $admin?->id,
                ]
            );
        }
    }
}
