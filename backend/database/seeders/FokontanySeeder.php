<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fokontany;

class FokontanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fokontany = [
            'Analakely',
            'Isotry',
            'Ankorondrano',
            'Ambohijatovo',
            'Andravoahangy',
        ];

        foreach ($fokontany as $nom) {
            Fokontany::create(['nom' => $nom]);
        }
    }
}