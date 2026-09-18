<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodicite extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'libelle',
        'description',
        'duree_jours',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}