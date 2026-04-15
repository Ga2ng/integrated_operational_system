<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $password = config('app.env') === 'local'
            ? 'password'
            : (env('ADMIN_DEFAULT_PASSWORD', 'ChangeMe!Strong1'));

        // Super admin (akun demo skripsi — ganti di production).
        $this->assign('admin@example.com', 'Admin User', 'super_admin', 'admin123');
        $this->assign('staff@example.com', 'Staff Admin', 'admin', $password);
        $this->assign('marketing@example.com', 'Marketing User', 'marketing', $password);
        $this->assign('customer@example.com', 'Customer Demo', 'customer', $password);
    }

    private function assign(string $email, string $name, string $roleCode, string $password): void
    {
        $role = Role::where('code', $roleCode)->first();
        if (! $role) {
            return;
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'role_id' => $role->id,
                'email_verified_at' => now(),
            ]
        );
    }
}
