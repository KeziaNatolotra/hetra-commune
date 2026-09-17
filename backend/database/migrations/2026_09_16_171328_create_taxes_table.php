<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('libelle');
            $table->text('description')->nullable();
            $table->decimal('montant', 12, 2);
            $table->enum('periodicite', [
                'journaliere',
                'hebdomadaire',
                'mensuelle',
                'trimestrielle',
                'semestrielle',
                'annuelle',
                'ponctuelle',
                'personnalisee',
            ]);
            $table->foreignId('contribuable_type_id')
                  ->nullable()
                  ->constrained('contribuable_types')
                  ->nullOnDelete();
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('taxes');
    }
};