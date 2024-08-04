<?php

namespace App\Http\Controllers\API\DB;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProcedimientoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['scope:admin']);
    }
    
    public function contarClientesUltimoMes()
    {
        $resultado = DB::select('CALL contar_clientes_ultimo_mes()');
        return response()->json($resultado);
    }

    public function totalVentasDiaAnterior()
    {
        $resultado = DB::select('CALL total_ventas_dia_anterior()');
        return response()->json($resultado);
    }

    public function contarVentasPorMedioEnv()
    {
        $resultado = DB::select('CALL contar_ventas_por_medio_env()');
        return response()->json($resultado);
    }
}
