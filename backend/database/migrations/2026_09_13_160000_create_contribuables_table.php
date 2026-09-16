<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contribuables', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('raison_sociale')->nullable();
            $table->string('cin')->nullable();
            $table->string('nif')->nullable();
            $table->string('stat')->nullable();
            $table->string('telephone')->nullable();
            $table->text('adresse')->nullable();
            $table->foreignId('fokontany_id')->nullable()->constrained('fokontany');
            $table->foreignId('contribuable_type_id')->nullable();    
	    $table->unsignedBigInteger('zone_id')->nullable();
            $table->unsignedBigInteger('marche_id')->nullable();
            $table->string('activite')->nullable();
            $table->string('emplacement')->nullable();
            $table->date('date_inscription')->nullable();
            $table->string('statut')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contribuables');
    }
};