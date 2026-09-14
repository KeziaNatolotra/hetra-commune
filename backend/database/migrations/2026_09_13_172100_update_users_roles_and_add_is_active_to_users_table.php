<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Modifier directement l'ENUM avec les nouveaux rôles
        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM(
                'admin',
                'responsable_financiere',
                'responsable_communal',
                'agent_collecteur',
                'contribuable'
            ) NOT NULL DEFAULT 'contribuable'
        ");
    }

    public function down(): void
    {
        // Revenir aux anciens rôles
        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM(
                'administrateur',
                'responsable_commune',
                'responsable_financière',
                'contribuable',
                'agent_collecteur'
            ) NOT NULL DEFAULT 'contribuable'
        ");
    }
};