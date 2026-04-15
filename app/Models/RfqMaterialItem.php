<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RfqMaterialItem extends Model
{
    protected $fillable = [
        'rfq_id',
        'material_inventory_id',
        'qty_needed',
        'estimated_cost',
    ];

    protected function casts(): array
    {
        return [
            'qty_needed' => 'decimal:2',
            'estimated_cost' => 'decimal:2',
        ];
    }

    public function rfq(): BelongsTo
    {
        return $this->belongsTo(Rfq::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(MaterialInventory::class, 'material_inventory_id');
    }
}
