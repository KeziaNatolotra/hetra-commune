<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Contribuable extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'nom',
        'prenom',
        'raison_sociale',
        'cin',
        'nif',
        'stat',
        'telephone',
        'adresse',
        'fokontany_id',
        'contribuable_type_id',
        'zone_id',
        'marche_id',
        'activite',
        'emplacement',
        'date_inscription',
        'statut',
    ];

    protected function casts(): array
    {
        return [
            'date_inscription' => 'date',
        ];
    }
    public function contribuableType(): BelongsTo
{
    return $this->belongsTo(ContribuableType::class);
}
}