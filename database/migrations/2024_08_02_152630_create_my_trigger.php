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
        DB::unprepared('
            CREATE TRIGGER after_user_update
            AFTER UPDATE ON users
            FOR EACH ROW
            BEGIN
                IF OLD.tel <> NEW.tel THEN
                    INSERT INTO user_audit_logs (user_id, field_changed, old_value, new_value)
                    VALUES (OLD.id, \'tel\', OLD.tel, NEW.tel);
                END IF;

                IF OLD.direccion <> NEW.direccion THEN
                    INSERT INTO user_audit_logs (user_id, field_changed, old_value, new_value)
                    VALUES (OLD.id, \'direccion\', OLD.direccion, NEW.direccion);
                END IF;

                IF OLD.genero <> NEW.genero THEN
                    INSERT INTO user_audit_logs (user_id, field_changed, old_value, new_value)
                    VALUES (OLD.id, \'genero\', OLD.genero, NEW.genero);
                END IF;
            END
        ');

        DB::unprepared('
        CREATE TRIGGER before_delete_ventas
        BEFORE DELETE ON ventas
        FOR EACH ROW
        BEGIN

            INSERT INTO cancelation_details (cancelation_id, nom_producto, pre_producto, cantidad, subtotal)
            SELECT OLD.id, dv.nom_producto, dv.pre_producto, dv.cantidad, dv.subtotal
            FROM detventas dv
            WHERE dv.venta_id = OLD.id;

            -- Insertar en la tabla de auditoría
            INSERT INTO cancelation_audit_logs (venta_id, user_id, canceled_at, reason)
            VALUES (OLD.id, OLD.user_id, NOW(), "Venta cancelada antes del pago");

            -- Insertar detalles en la tabla de detalles de cancelación

        END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_user_update');
        DB::unprepared('DROP TRIGGER IF EXISTS after_delete_ventas');
    }
};
