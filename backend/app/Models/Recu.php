<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recu extends Model
{
    use HasFactory;

    protected $fillable = [
        'paiement_id',
        'numero_recu',
        'montant',
        'date_emission',
        'statut',
        'motif_annulation',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'date_emission' => 'datetime',
    ];

    public function paiement()
    {
        return $this->belongsTo(Paiement::class);
    }
}