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
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('paiement_id')->constrained('paiements')->cascadeOnDelete();
        $table->string('reference_externe')->unique();
        $table->enum('statut', ['pending', 'succes', 'echec', 'expire'])->default('pending');
        $table->timestamp('callback_recu_at')->nullable();
        $table->json('callback_payload')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
