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

        Schema::create('archived_students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('index_number');
            // $table->foreignId('program_id')->constrained('Programs');
            $table->foreignId('program_id')->constrained()->nullOnDelete();
            $table->string('telephone');
            $table->enum('level', ["100", "200", "300", "400", "500", "600"]);
            $table->enum('program_type', ["regular", "top_up"]);
            $table->string('telcos_number');
            $table->string('serial_number');
            $table->year('expected_completion_year');
            $table->timestamp('registered_at')->nullable(); // This is the date the student was registered on the system
            $table->timestamp('last_updated_at')->nullable(); // This is the date the student was last updated on the system
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archived_students');
    }
};
