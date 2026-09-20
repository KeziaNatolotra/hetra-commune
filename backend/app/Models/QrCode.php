<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'contribuable_id',
        'code',
        'is_active',
        'genere_at',
        'desactive_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'genere_at' => 'datetime',
        'desactive_at' => 'datetime',
    ];

    public function contribuable()
    {
        return $this->belongsTo(Contribuable::class);
    }
}