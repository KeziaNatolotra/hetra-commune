<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Periodicite;

class PeriodiciteSeeder extends Seeder
{
    public function run(): void
    {
        $periodicites = [
            ['code' => 'journaliere', 'libelle' => 'Journalière', 'duree_jours' => 1],
            ['code' => 'hebdomadaire', 'libelle' => 'Hebdomadaire', 'duree_jours' => 7],
            ['code' => 'mensuelle', 'libelle' => 'Mensuelle', 'duree_jours' => 30],
            ['code' => 'trimestrielle', 'libelle' => 'Trimestrielle', 'duree_jours' => 90],
            ['code' => 'semestrielle', 'libelle' => 'Semestrielle', 'duree_jours' => 180],
            ['code' => 'annuelle', 'libelle' => 'Annuelle', 'duree_jours' => 365],
            ['code' => 'ponctuelle', 'libelle' => 'Ponctuelle', 'duree_jours' => null],
            ['code' => 'personnalisee', 'libelle' => 'Personnalisée', 'duree_jours' => null],
        ];

        foreach ($periodicites as $p) {
            Periodicite::updateOrCreate(['code' => $p['code']], $p);
        }
    }
}