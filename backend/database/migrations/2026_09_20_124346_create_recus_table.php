<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('recus', function (Blueprint $table) {
        $table->id();
        $table->foreignId('paiement_id')->unique()->constrained('paiements')->cascadeOnDelete();
        $table->string('numero_recu')->unique();
        $table->decimal('montant', 12, 2);
        $table->timestamp('date_emission');
        $table->enum('statut', ['valide', 'annule'])->default('valide');
        $table->text('motif_annulation')->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recus');
    }
};
