<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('obligations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contribuable_id')->constrained('contribuables')->cascadeOnDelete();
            $table->foreignId('taxe_id')->constrained('taxes')->cascadeOnDelete();
            $table->foreignId('affectation_id')->nullable()->constrained('affectations')->nullOnDelete();
            $table->date('periode_debut');
            $table->date('periode_fin')->nullable();
            $table->date('date_echeance');
            $table->decimal('montant_du', 12, 2);
            $table->decimal('montant_paye', 12, 2)->default(0);
            $table->enum('statut', [
                'a_payer',
                'partiellement_paye',
                'paye',
                'en_retard',
                'exonere',
                'annule',
            ])->default('a_payer');
            $table->text('motif_annulation')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obligations');
    }
};