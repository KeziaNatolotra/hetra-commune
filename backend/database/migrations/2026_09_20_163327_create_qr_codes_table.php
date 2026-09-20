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
    Schema::create('qr_codes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('contribuable_id')->constrained('contribuables')->cascadeOnDelete();
        $table->string('code')->unique();
        $table->boolean('is_active')->default(true);
        $table->timestamp('genere_at');
        $table->timestamp('desactive_at')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_codes');
    }
};
