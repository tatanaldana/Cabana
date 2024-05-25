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
        Schema::create('detpromociones', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad')->notNull();
            $table->integer('descuento')->notNull();
            $table->integer('subtotal')->notNull();
            $table->timestamps();
            $table->unsignedBigInteger('promocione_id')->nullable();
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->foreign('promocione_id')->references('id')->on('promociones')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detpromociones');
    }
};
