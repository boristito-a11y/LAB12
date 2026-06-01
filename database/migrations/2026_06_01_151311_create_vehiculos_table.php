<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('modelo', 150);
            $table->integer('anio');
            $table->decimal('precio', 10, 2);
            $table->integer('kilometraje');
            $table->string('foto')->nullable();
            $table->foreignId('marca_id')->constrained('marcas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};