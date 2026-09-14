<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crée la table des permissions.
     */
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();

            // Nom technique de la permission
            // Exemple : users.create
            $table->string('nom')->unique();

            // Description lisible de la permission
            $table->text('description')->nullable();

            // Permet d'activer ou désactiver une permission
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Supprime la table des permissions.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};