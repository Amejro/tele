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
        //Schema::disableForeignKeyConstraints();

        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('duration');
            $table->unsignedBigInteger('school_id');
            // $table->integer('top_up_duration')->nullable();
            // $table->boolean('has_top_up');
            $table->string('program_code')->nullable();
            $table->foreignId('school_id')->references('id')->on('schools')->onDelete('cascade');

            //$table->foreignId('school_id')->constrained()->nullOnDelete();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
