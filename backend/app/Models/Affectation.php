<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Affectation extends Model
{
    use HasFactory;

    protected $fillable = [
        'taxe_id',
        'contribuable_id',
        'contribuable_type_id',
        'zone_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function taxe(): BelongsTo
    {
        return $this->belongsTo(Taxe::class);
    }

    public function contribuable(): BelongsTo
    {
        return $this->belongsTo(Contribuable::class);
    }

    public function contribuableType(): BelongsTo
    {
        return $this->belongsTo(ContribuableType::class);
    }
}