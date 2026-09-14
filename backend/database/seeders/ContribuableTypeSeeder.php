<?php

namespace Database\Seeders;

use App\Models\ContribuableType;
use Illuminate\Database\Seeder;

class ContribuableTypeSeeder extends Seeder
{
    public function run(): void
    {
        ContribuableType::insert([
            [
                'nom' => 'Commerçant',
            ],
            [
                'nom' => 'Artisan',
            ],
            [
                'nom' => 'Entreprise',
            ],
        ]);
    }
}