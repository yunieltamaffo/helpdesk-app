<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->string('title');
            $table->text('description');
            $table->enum('category', ['reseau', 'materiel', 'logiciel', 'acces', 'autre'])->default('autre');
            $table->enum('priority', ['basse', 'moyenne', 'haute', 'urgente'])->default('moyenne');
            $table->enum('status', ['ouvert', 'en_cours', 'en_attente', 'resolu', 'ferme'])->default('ouvert');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};