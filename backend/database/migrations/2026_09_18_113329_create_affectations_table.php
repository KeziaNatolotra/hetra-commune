<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('affectations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('taxe_id')->constrained('taxes')->cascadeOnDelete();
            $table->foreignId('contribuable_id')->nullable()->constrained('contribuables')->cascadeOnDelete();
            $table->foreignId('contribuable_type_id')->nullable()->constrained('contribuable_types')->cascadeOnDelete();
            $table->foreignId('zone_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('affectations');
    }
};