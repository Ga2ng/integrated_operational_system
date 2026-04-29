<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificationAnswer extends Model
{
    protected $fillable = [
        'certification_participant_id',
        'certification_requirement_id',
        'answer_text',
        'file_path',
    ];

    public function participant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CertificationParticipant::class, 'certification_participant_id');
    }

    public function requirement(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CertificationRequirement::class, 'certification_requirement_id');
    }
}
