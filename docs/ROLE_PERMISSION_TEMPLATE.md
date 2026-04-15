# Role-Permission Template Plan (Reusable)

Dokumen ini adalah template implementasi ulang sistem `User -> Role -> Permission` berbasis struktur project ini. Tujuannya: bisa langsung dipakai di project lain sebagai blueprint plan Cursor.

---

## 1) Target Arsitektur (sama seperti project ini)

```text
users (many) -> belongsTo -> roles (one)
roles (many) <-> belongsToMany <-> permissions (many) via permission_role
```

- User hanya punya satu role (`users.role_id`).
- Hak akses user berasal dari permission role-nya.
- Cek akses dilakukan via:
  - `Gate::authorize('permission', 'module.action')`
  - `@can('permission', 'module.action')` di Blade.
- Super admin bypass semua permission melalui `Gate::before`.

---

## 2) Struktur File Template

Salin pola struktur berikut:

```text
app/
  Models/
    User.php
    Role.php
    Permission.php
  Providers/
    AppServiceProvider.php
  Http/
    Middleware/
      EnsureUserHasPermission.php
bootstrap/
  app.php
database/
  migrations/
    *_create_roles_table.php
    *_create_permissions_table.php
    *_create_permission_role_table.php
    *_add_role_id_to_users_table.php
  seeders/
    PermissionSeeder.php
    RoleSeeder.php
    AdminUserSeeder.php
    DatabaseSeeder.php
resources/
  views/
    components/admin/sidebar.blade.php (opsional, untuk @can menu)
```

---

## 3) Alur End-to-End

1. Seeder `PermissionSeeder` membuat master daftar permission (`code` unik).
2. Seeder `RoleSeeder` membuat role lalu mapping permission ke role (`sync` pivot).
3. Seeder `AdminUserSeeder` membuat user default lalu assign `role_id`.
4. User login.
5. Saat akses fitur, sistem cek permission lewat gate:
   - super admin -> lolos semua;
   - selain itu -> cek `user->hasPermission('module.action')`.
6. Controller / Blade menolak akses bila tidak punya permission.

---

## 4) Template Migrasi (Checklist)

Wajib ada:

- `roles`
  - `id`, `name`, `code` (unique), `description`, `sort_order`, `is_active`, timestamps.
- `permissions`
  - `id`, `module`, `name`, `code` (unique), `description`, `sort_order`, `is_active`, timestamps.
- `permission_role` (pivot)
  - `permission_id` FK, `role_id` FK, PK gabungan (`permission_id`, `role_id`).
- `users.role_id`
  - nullable FK ke `roles.id`.

---

## 5) Template Model Logic

## `app/Models/User.php`
- Tambah `role_id` di `$fillable`.
- Relasi:
  - `role(): BelongsTo`
- Method utama:
  - `hasPermission(string $code): bool`
  - `isSuperAdmin(): bool`

Flow `hasPermission` (mengikuti project ini):
- return `false` jika `role_id` kosong.
- load role, return `false` jika role tidak ada / tidak aktif.
- delegasi ke `Role::hasPermission($code)`.

## `app/Models/Role.php`
- Relasi:
  - `permissions(): BelongsToMany` via `permission_role`
  - `users(): HasMany`
- Method:
  - `hasPermission(string $code): bool` -> query permission aktif berdasarkan `code`.

## `app/Models/Permission.php`
- Simpan metadata `module`, `name`, `code`, `sort_order`, `is_active`.

---

## 6) Template Gate & Middleware

## `app/Providers/AppServiceProvider.php`

Definisikan:

1. `Gate::before(...)`
   - jika `isSuperAdmin()`, return `true`.
2. `Gate::define('permission', fn($user, string $code) => $user->hasPermission($code));`
3. (Opsional) gate gabungan, contoh:
   - `user-role.view` (role.view ATAU user.view).
4. (Opsional) gate level resource, contoh:
   - `unit.access` (cek permission + ownership record).

## `app/Http/Middleware/EnsureUserHasPermission.php`

Parameter middleware: `permission:<code>`, contoh:
- `->middleware('permission:booking.view')`

Isi middleware:
- jika guest -> redirect login;
- jika super admin -> lanjut;
- jika tidak punya permission -> abort 403;
- selain itu -> lanjut.

## `bootstrap/app.php`

Daftarkan alias middleware:

```php
'permission' => \App\Http\Middleware\EnsureUserHasPermission::class,
```

---

## 7) Template Seeder (Inti Fleksibilitas)

## `database/seeders/PermissionSeeder.php`

Pola penting:
- simpan daftar permission sebagai array map.
- gunakan `Permission::updateOrCreate(['code' => ...], [...])`.
- aktifkan default `is_active = true`.
- boleh ada blok migrasi permission lama (rename/hapus code lama) agar backward-compatible.
- opsional: sinkronkan ulang super admin agar selalu dapat semua permission.

Konvensi penamaan code (project ini):
- `dashboard.view`
- `booking.view|create|update|delete|confirm|cancel|checkin|checkout|request_refund|refund|booking_guest`
- `role.view|create|update|delete`
- `user.view|create|update|delete`
- `landing_content.view|update`

Pattern umum:

```text
{module}.{action}
```

## `database/seeders/RoleSeeder.php`

Pola:
- `Role::updateOrCreate(['code' => '...'], [...])`
- mapping permission per role dengan:
  - `Permission::whereIn('code', [...])->pluck('id')`
  - `$role->permissions()->sync(...)`

Role bawaan di project ini:
- `super_admin`
- `building_admin`
- `front_office`
- `customer`
- `marketing`
- `qc`
- `internal`

## `database/seeders/AdminUserSeeder.php`

Pola:
- helper `assign(email, name, roleCode)`.
- cari role by code.
- `User::updateOrCreate(['email' => ...], ['name' => ..., 'password' => ..., 'role_id' => ...])`

Catatan:
- pakai password default hanya untuk development/staging.
- production wajib ganti via `.env` atau secret manager.

## `database/seeders/DatabaseSeeder.php`

Urutan penting:
1. `PermissionSeeder`
2. `RoleSeeder`
3. `AdminUserSeeder`
4. Seeder domain lain

---

## 8) Pola Enforcement di Controller & Blade

## Controller

Di awal method:

```php
Gate::authorize('permission', 'booking.update');
```

## Blade

Untuk menu/tombol:

```blade
@can('permission', 'user.create')
    <a href="...">Tambah User</a>
@endcan
```

Opsional direct check:

```php
auth()->user()?->hasPermission('report.finance.view')
```

---

## 9) Flexibility Rules (Agar jadi template jangka panjang)

- Jangan hardcode role name di controller untuk hak fitur; pakai permission `code`.
- Simpan role code hanya untuk pengecualian global (misal super admin bypass).
- Tambah permission baru dengan cara:
  1) tambah di `PermissionSeeder`,
  2) map ke role terkait di `RoleSeeder`,
  3) panggil `Gate::authorize('permission', 'new.code')` di endpoint.
- Kalau rename permission, sediakan migrasi mapping code lama -> code baru di seeder.
- Gunakan `updateOrCreate` agar aman dijalankan berulang.

---

## 10) SOP Implementasi di Project Baru

1. Buat migrasi role-permission-user link.
2. Buat model + relasi + helper `hasPermission`.
3. Pasang gate `permission` + super admin bypass.
4. Buat middleware `permission` dan alias bootstrap.
5. Buat `PermissionSeeder`, `RoleSeeder`, `AdminUserSeeder`.
6. Daftarkan urutan seed di `DatabaseSeeder`.
7. Proteksi controller dan menu dengan gate.
8. Jalankan:
   - `php artisan migrate`
   - `php artisan db:seed`
9. Verifikasi:
   - user super admin akses penuh;
   - role lain hanya dapat fitur sesuai mapping.

---

## 11) Snippet Plan Cursor (siap tempel)

Gunakan prompt ini di plan Cursor saat mulai project baru:

```text
Implement sistem role-permission dengan arsitektur:
- users.role_id (1 user = 1 role)
- roles <-> permissions via permission_role
- Gate::before super_admin bypass
- Gate::define('permission', ...)
- Seeder berurutan: PermissionSeeder -> RoleSeeder -> AdminUserSeeder
- updateOrCreate untuk role/permission/user
- mapping permission by code (module.action)

Buat struktur file setara:
app/Models/{User,Role,Permission}.php
app/Providers/AppServiceProvider.php
app/Http/Middleware/EnsureUserHasPermission.php
database/migrations/*roles*, *permissions*, *permission_role*, *add_role_id_to_users*
database/seeders/{PermissionSeeder,RoleSeeder,AdminUserSeeder,DatabaseSeeder}.php

Pastikan controller menggunakan Gate::authorize('permission', 'module.action')
dan blade menu memakai @can('permission', 'module.action').
```

---

## 12) Catatan Praktis dari Project Ini

- Project ini fleksibel karena semua akses modul diturunkan dari string permission, bukan hardcode role.
- Untuk fitur domain tertentu, bisa pakai gate resource-level tambahan (contoh: `unit.access`).
- Registrasi publik default belum otomatis assign role; jika diperlukan, tambahkan assignment role default pada flow register.

