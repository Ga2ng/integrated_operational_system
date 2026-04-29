<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificationRequirement extends Model
{
    protected $fillable = [
        'certification_program_id',
        'question',
        'type',
        'is_required',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_required' => 'boolean',
        ];
    }

    public function program(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CertificationProgram::class, 'certification_program_id');
    }
}
