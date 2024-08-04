<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("
            CREATE PROCEDURE contar_clientes_ultimo_mes()
            BEGIN
                SELECT COUNT(*) AS cantidad_clientes
                FROM users
                WHERE created_at >= CURDATE() - INTERVAL 1 MONTH;
            END
        ");

        DB::unprepared("
            CREATE PROCEDURE total_ventas_dia_anterior()
            BEGIN
                SELECT SUM(total) AS valor_total_ventas
                FROM ventas
                WHERE DATE(created_at) = CURDATE() - INTERVAL 1 DAY;
            END
        ");

        DB::unprepared("
            CREATE PROCEDURE contar_ventas_por_medio_env()
            BEGIN
                SELECT 
                    medio_env,
                    COUNT(*) AS cantidad_ventas
                FROM ventas
                GROUP BY medio_env;
            END
        ");
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP PROCEDURE IF EXISTS contar_clientes_ultimo_mes;");
        DB::statement("DROP PROCEDURE IF EXISTS total_ventas_dia_anterior;");
        DB::statement("DROP PROCEDURE IF EXISTS contar_ventas_por_medio_env;");
    }
};
