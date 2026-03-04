<?php

namespace App\Http\Controllers;

use App\Models\Consentimiento;
use App\Models\Factura;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function descargarConsentimiento(Consentimiento $record)
    {
        $pdf = Pdf::loadView('pdf.consentimiento', ['record' => $record]);

        return $pdf->download("consentimiento-{$record->id}.pdf");
    }

    public function descargarFactura(Factura $record)
    {
        $pdf = Pdf::loadView('pdf.factura', ['record' => $record]);

        return $pdf->download("factura-{$record->numero_factura}.pdf");
    }
}
