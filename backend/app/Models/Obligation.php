<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obligation extends Model
{
    use HasFactory;

    protected $fillable = [
        'contribuable_id',
        'taxe_id',
        'affectation_id',
        'periode_debut',
        'periode_fin',
        'date_echeance',
        'montant_du',
        'montant_paye',
        'statut',
        'motif_annulation',
    ];

    protected $casts = [
        'periode_debut'  => 'date',
        'periode_fin'    => 'date',
        'date_echeance'  => 'date',
        'montant_du'     => 'decimal:2',
        'montant_paye'   => 'decimal:2',
    ];

    public function contribuable()
    {
        return $this->belongsTo(Contribuable::class);
    }

    public function taxe()
    {
        return $this->belongsTo(Taxe::class);
    }

    public function affectation()
    {
        return $this->belongsTo(Affectation::class);
    }
}