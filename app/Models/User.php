<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function clientProfile(): HasOne
    {
        return $this->hasOne(ClientProfile::class);
    }

    public function rfqsAsClient(): HasMany
    {
        return $this->hasMany(Rfq::class, 'client_user_id');
    }

    public function certificatesAsParticipant(): HasMany
    {
        return $this->hasMany(Certificate::class, 'participant_user_id');
    }

    public function managedProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'manager_user_id');
    }

    public function isSuperAdmin(): bool
    {
        return $this->role?->code === 'super_admin';
    }

    public function hasPermission(string $code): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if ($this->role_id === null) {
            return false;
        }

        $role = $this->relationLoaded('role') ? $this->role : $this->role()->first();

        if (! $role || ! $role->is_active) {
            return false;
        }

        return $role->hasPermission($code);
    }

    public function canAccessAdminPanel(): bool
    {
        return $this->hasPermission('dashboard.view');
    }
}
