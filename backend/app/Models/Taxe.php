<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxe extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'libelle',
        'description',
        'montant',
        'periodicite',
        'contribuable_type_id',
        'date_debut',
        'date_fin',
        'is_active',
    ];

    protected $casts = [
        'montant'    => 'decimal:2',
        'date_debut' => 'date',
        'date_fin'   => 'date',
        'is_active'  => 'boolean',
    ];

    public function contribuableType()
    {
        return $this->belongsTo(ContribuableType::class);
    }
}