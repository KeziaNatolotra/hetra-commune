<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'nom' => 'admin',
                'description' => 'Administrateur du système',
                'is_active' => true,
            ],
            [
                'nom' => 'responsable_financiere',
                'description' => 'Responsable des opérations financières et fiscales',
                'is_active' => true,
            ],
            [
                'nom' => 'responsable_communal',
                'description' => 'Responsable de la gestion communale',
                'is_active' => true,
            ],
            [
                'nom' => 'agent_collecteur',
                'description' => 'Agent chargé de la collecte et du contrôle sur le terrain',
                'is_active' => true,
            ],
            [
                'nom' => 'contribuable',
                'description' => 'Utilisateur contribuable',
                'is_active' => true,
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['nom' => $role['nom']],
                [
                    'description' => $role['description'],
                    'is_active' => $role['is_active'],
                ]
            );
        }
    }
}