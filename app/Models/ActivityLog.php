<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'method',
        'url',
        'route_name',
        'ip_address',
        'user_agent',
        'request_payload',
        'description',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'request_payload' => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
