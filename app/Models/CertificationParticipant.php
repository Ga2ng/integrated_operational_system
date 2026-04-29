<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificationParticipant extends Model
{
    protected $fillable = [
        'certification_program_id',
        'participant_user_id',
        'status',
        'submitted_at',
        'review_notes',
        'assigned_by',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
        ];
    }

    public function program(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CertificationProgram::class, 'certification_program_id');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'participant_user_id');
    }

    public function assignedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function answers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CertificationAnswer::class);
    }
}
