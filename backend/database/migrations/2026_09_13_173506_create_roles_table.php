<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crée la table des rôles.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();

            // Nom du rôle
            $table->string('nom')->unique();

            // Description du rôle
            $table->text('description')->nullable();

            // Permet d'activer ou désactiver un rôle
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Supprime la table des rôles.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};