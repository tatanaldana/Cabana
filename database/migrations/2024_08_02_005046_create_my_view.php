<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared("
            CREATE VIEW promocion_mas_unidades_vendidas AS
            SELECT 
                p.id AS promocion_id,
                p.nom_promo AS nombre_promocion,
                SUM(d.cantidad) AS total_unidades_vendidas
            FROM
                detventas d
                JOIN promociones p ON d.nom_producto = p.nom_promo
            GROUP BY p.id, p.nom_promo;
        ");

        DB::unprepared("
            CREATE VIEW producto_mas_vendido AS
            SELECT 
                nom_producto,
                SUM(cantidad) AS total_cantidad_vendida
            FROM
                detventas
            GROUP BY nom_producto;
        ");

        DB::unprepared("
            CREATE VIEW cliente_mas_ventas AS
            SELECT 
                u.id AS user_id,
                u.name AS nombre_usuario,
                COUNT(v.id) AS total_ventas
            FROM
                ventas v
                JOIN users u ON v.user_id = u.id
            GROUP BY u.id, u.name;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS promocion_mas_unidades_vendidas;");
        DB::statement("DROP VIEW IF EXISTS producto_mas_vendido;");
        DB::statement("DROP VIEW IF EXISTS cliente_mas_ventas;");
    }
};
