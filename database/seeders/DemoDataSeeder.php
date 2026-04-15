<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\ClientProfile;
use App\Models\Product;
use App\Models\Project;
use App\Models\Rfq;
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

        Product::updateOrCreate(
            ['name' => 'Pelatihan K3 Umum'],
            [
                'description' => 'Pelatihan keselamatan dan kesehatan kerja tingkat dasar.',
                'unit' => 'peserta',
                'base_price' => 1500000,
                'availability_status' => 'available',
                'is_active' => true,
                'created_by' => $admin?->id,
                'updated_by' => $admin?->id,
            ]
        );

        Product::updateOrCreate(
            ['name' => 'Sertifikasi Kompetensi Bidang Listrik'],
            [
                'description' => 'Uji kompetensi dan sertifikasi teknisi listrik.',
                'unit' => 'orang',
                'base_price' => 2500000,
                'availability_status' => 'available',
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

        $product = Product::where('name', 'Pelatihan K3 Umum')->first();

        if ($customer && $product) {
            Rfq::firstOrCreate(
                [
                    'client_user_id' => $customer->id,
                    'product_id' => $product->id,
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
