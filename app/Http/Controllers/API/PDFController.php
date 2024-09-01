<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Venta;
use App\Http\Requests\API\PDFRequest;
use App\Models\Pqr;

class PDFController extends Controller
{
    public function generatePdf(PDFRequest $request)
    {
        $data = $request->validated();

        $venta = Venta::with('user', 'detventas')->findOrFail($data['id']);

        $pdf = PDF::loadView('pdf.comprobante', ['venta' => $venta]);
        return $pdf->download('comprobante.pdf');
    }

    public function generatePdf2(PDFRequest $request)
    {
        $data = $request->validated();

        $pqr = Pqr::with('user')->findOrFail($data['id']);

        $pdf = PDF::loadView('pdf.constancia', ['pqr' => $pqr]);
        return $pdf->download('constancia.pdf');
    }



}
