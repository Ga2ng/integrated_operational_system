<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    protected $fillable = [
        'participant_user_id',
        'project_id',
        'certification_program_id',
        'issued_at',
        'valid_until',
        'document_path',
        'validation_code',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'issued_at' => 'date',
            'valid_until' => 'date',
        ];
    }

    public function participant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'participant_user_id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function certificationProgram(): BelongsTo
    {
        return $this->belongsTo(CertificationProgram::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
