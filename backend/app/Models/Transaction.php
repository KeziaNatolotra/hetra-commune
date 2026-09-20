<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'paiement_id',
        'reference_externe',
        'statut',
        'callback_recu_at',
        'callback_payload',
    ];

    protected $casts = [
        'callback_recu_at' => 'datetime',
        'callback_payload' => 'array',
    ];

    public function paiement()
    {
        return $this->belongsTo(Paiement::class);
    }
}