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
    Schema::create('paiements', function (Blueprint $table) {
        $table->id();
        $table->foreignId('obligation_id')->constrained('obligations')->cascadeOnDelete();
        $table->foreignId('initiateur_id')->constrained('users')->cascadeOnDelete();
        $table->decimal('montant', 12, 2);
        $table->enum('moyen', ['mobile_money'])->default('mobile_money');
        $table->enum('statut', ['pending', 'succes', 'echec'])->default('pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
