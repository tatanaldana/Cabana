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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->string('metodo_pago',20);
            $table->boolean('estado')->default(false);   
            $table->integer('total')->nullable();  
            $table->timestamps(); 
            $table->bigInteger('user_id')->unsigned();
           // $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');*/
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
