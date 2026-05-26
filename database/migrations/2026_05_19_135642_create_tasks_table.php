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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            // Relación con el usuario logueado de Breeze
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->boolean('is_completed')->default(false);
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->date('due_date')->nullable(); // Fecha de vencimiento
            $table->string('priority')->default('Media'); // Prioridad (Baja, Media, Alta)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
