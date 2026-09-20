<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'obligation_id',
        'initiateur_id',
        'montant',
        'moyen',
        'statut',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
    ];

    public function obligation()
    {
        return $this->belongsTo(Obligation::class);
    }

    public function initiateur()
    {
        return $this->belongsTo(User::class, 'initiateur_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
    public function recu()
    {
    return $this->hasOne(Recu::class);
    }
}