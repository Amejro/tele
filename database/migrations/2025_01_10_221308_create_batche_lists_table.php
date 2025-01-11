<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('batche_lists', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->unique();
            $table->string('caller_number')->unique();
            $table->foreignId('batche_id')->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batche_lists');
    }
};
