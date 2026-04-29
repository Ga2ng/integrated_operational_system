<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaterialInventory extends Model
{
    protected $fillable = [
        'code',
        'name',
        'specification',
        'image',
        'uom',
        'current_stock',
        'minimum_stock',
        'unit_cost',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'current_stock' => 'decimal:2',
            'minimum_stock' => 'decimal:2',
            'unit_cost' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function rfqItems(): HasMany
    {
        return $this->hasMany(RfqMaterialItem::class);
    }

    public function stockLogs(): HasMany
    {
        return $this->hasMany(MaterialStockLog::class, 'material_inventory_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getStockStatusAttribute(): string
    {
        return $this->current_stock <= $this->minimum_stock ? 'LOW' : 'OK';
    }
}
