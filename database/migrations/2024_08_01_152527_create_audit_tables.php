<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('user_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id'); 
            $table->string('field_changed');
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->string('changed_by')->nullable(); 
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('cancelation_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venta_id'); 
            $table->bigInteger('user_id');
            $table->timestamp('canceled_at');
            $table->text('reason')->nullable(); 

            $table->foreign('venta_id')->references('id')->on('ventas')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });

        Schema::create('cancelation_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cancelation_id');
            $table->string('nom_producto', 50);
            $table->integer('pre_producto');
            $table->integer('cantidad');
            $table->integer('subtotal');

            $table->foreign('cancelation_id')->references('id')->on('cancelation_audit_logs')->onDelete('cascade');
        });

    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_audit_logs', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('cancelation_audit_logs', function (Blueprint $table) {
            $table->dropForeign(['venta_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::table('cancelation_details', function (Blueprint $table) {
            $table->dropForeign(['cancelation_id']);
        });

        Schema::dropIfExists('user_audit_logs');
        Schema::dropIfExists('cancelation_audit_logs');
        Schema::dropIfExists('cancelation_details');
    }
};
