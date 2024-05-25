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
        Schema::create('matprimas', function (Blueprint $table) {
            $table->id();
            $table->string('referencia',50);
            $table->string('descripcion');
            $table->integer('existencia')->notNull();
            $table->integer('entrada')->notNull();
            $table->integer('salida')->notNull();
            $table->integer('stock')->notNull();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matprimas');
    }
};
