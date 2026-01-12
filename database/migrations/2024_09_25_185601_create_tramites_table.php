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
        Schema::create('tramites', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->boolean('estado')->default(1);
            $table->decimal('precio', 10, 2);
            $table->decimal('gastos', 10, 2);
            $table->text('observaciones')->nullable();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('tipo_tramite_id')->constrained('tipo_tramites');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tramites');
    }
};
