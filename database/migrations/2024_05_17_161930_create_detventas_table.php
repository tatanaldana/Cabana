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
        Schema::create('detventas', function (Blueprint $table) {
            $table->id();
            $table->string('nom_producto',50);
            $table->integer('pre_producto')->notNull();
            $table->integer('cantidad')->notNull();
            $table->integer('subtotal')->notNull();
            $table->timestamps();
            $table->unsignedBigInteger('venta_id')->nullable();
            $table->foreign('venta_id')->references('id')->on('ventas')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detventas');
    }
};
