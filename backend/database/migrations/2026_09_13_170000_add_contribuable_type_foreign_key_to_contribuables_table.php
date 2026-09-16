<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contribuables', function (Blueprint $table) {
            $table->foreign('contribuable_type_id')
                ->references('id')
                ->on('contribuable_types')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::table('contribuables', function (Blueprint $table) {
            $table->dropForeign(['contribuable_type_id']);
        });
    }
};