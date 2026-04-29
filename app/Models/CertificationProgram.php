<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificationProgram extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function requirements(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CertificationRequirement::class);
    }

    public function participants(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CertificationParticipant::class);
    }

    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
