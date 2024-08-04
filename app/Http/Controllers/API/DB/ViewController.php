<?php

namespace App\Http\Controllers\API\DB;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['scope:admin']);
    }

    public function promocionMasUnidadesVendidas()
    {
        $resultado = DB::table('promocion_mas_unidades_vendidas')->get();
        return response()->json($resultado);
    }

    public function productoMasVendido()
    {
        $resultado = DB::table('producto_mas_vendido')->get();
        return response()->json($resultado);
    }

    public function clienteMasVentas()
    {
        $resultado = DB::table('cliente_mas_ventas')->get();
        return response()->json($resultado);
    }
}
