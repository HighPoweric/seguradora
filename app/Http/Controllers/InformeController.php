<?php
namespace App\Http\Controllers;

use App\Services\InformeService;
use App\Models\Peritaje;
use Illuminate\Http\Request;

class InformeController extends Controller
{
    protected $informeService;

    public function __construct(InformeService $informeService)
    {
        $this->informeService = $informeService;
    }

    public function generarInforme($peritajeId)
    {
        try {
            $filePath = $this->informeService->generarInformePeritaje($peritajeId);
            
            return response()->download($filePath)->deleteFileAfterSend(true);
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al generar el informe: ' . $e->getMessage());
        }
    }

    public function vistaPrevia($peritajeId)
    {
        $peritaje = Peritaje::with([
            'siniestro.vehiculo',
            'siniestro.asegurado',
            'siniestro.conductor',
            'siniestro.denunciante', 
            'siniestro.contratante',
            'perito',
            'checklistDocumentos.documento'
        ])->findOrFail($peritajeId);

        return view('informes.vista-previa', compact('peritaje'));
    }
}