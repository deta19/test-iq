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
        Schema::create('orases', function (Blueprint $table) {
            $table->id();
            $table->string('nume');
            $table->foreignId('judet_id')->constrained('judets')->onDelete('cascade');
            $table->decimal('coord_x', 8, 5);
            $table->decimal('coord_y', 8, 5);
            $table->string('populatie');
            $table->string('regiune');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orase');
    }
};
