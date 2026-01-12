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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombres', 50);
            $table->string('apellidos', 50);
            $table->string('dpi', 13)->unique();
            $table->string('nit', 13)->unique();
            $table->string('direccion', 255);
            $table->string('telefono', 8);
            $table->string('email', 100)->unique()->nullable();
            $table->boolean('estado')->default(1);

            $table->foreignId('tipo_cliente_id')->constrained('tipo_clientes');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
