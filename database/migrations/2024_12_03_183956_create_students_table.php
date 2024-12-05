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
        Schema::disableForeignKeyConstraints();

        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('index_number')->unique();
            $table->foreignId('program_id')->constrained('Programs');
            $table->string('telephone');
            $table->enum('level', ["100", "200", "300", "400", "500", "600"]);
            $table->enum('program_type', ["regular", "top_up"]);
            $table->enum('status', ["active", "graduating", "graduated"]);
            $table->string('telcos_number');
            $table->string('serial_number');
            $table->year('expected_completion_year');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
