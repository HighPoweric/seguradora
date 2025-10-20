<?php
namespace App\Services;

use Phpoffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Models\Peritaje;
use App\Models\Siniestro;
use App\Models\Participante;
use App\Models\Perito;
use App\Models\Vehiculo;


class InformeService
{
    public function generarInformePeritaje($peritajeId)
    {
        // Lógica para generar documentos
        $peritaje = Peritaje::with([
            'siniestro.vehiculo',
            'siniestro.asegurado',
            'siniestro.conductor', 
            'siniestro.denunciante',
            'siniestro.contratante',
            'perito',
            'checklistDocumentos.documento'
        ])->findOrFail($peritajeId);
        $siniestro = $peritaje->siniestro;

        $templatePath = resource_path('templates/Informe_Plantilla_id7.docx');
        $templateProcessor = new TemplateProcessor($templatePath);

        // Reemplazar los placeholders con datos reales
        $this->reemplazarDatosGenerales($templateProcessor, $peritaje, $siniestro);
        $this->reemplazarDatosSiniestro($templateProcessor, $siniestro);
        $this->reemplazarParticipantes($templateProcessor, $siniestro);
        $this->reemplazarDocumentacion($templateProcessor, $peritaje);
        $this->reemplazarEntrevistas($templateProcessor, $peritaje);

        // Generar nombre del archivo
        $fileName = 'Informe_Siniestro_' . $siniestro->id_interno . '_' . now()->format('Ymd') . '.docx';
        $filePath = storage_path('app/private/peritajes/' . $peritajeId . '/informe/' . $fileName);

        // Crear el directorio si no existe
        if (!file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0777, true);
        }

        // Guardar el documento
        $templateProcessor->saveAs($filePath);

        return $filePath;
    }

    private function reemplazarDatosGenerales($templateProcessor, $peritaje, $siniestro)
    {
        $templateProcessor->setValue('NUMERO_SINIESTRO', $siniestro->id_interno);
        $templateProcessor->setValue('SOLICITADO_POR', $peritaje->solicitante);
        $templateProcessor->setValue('VEHICULO_ASEGURADO', 
            $siniestro->vehiculo->marca . ' ' . $siniestro->vehiculo->modelo . ' - ' . $siniestro->vehiculo->patente);
        $templateProcessor->setValue('FECHA_OCURRENCIA', $siniestro->fecha_siniestro->format('d/m/Y'));
        $templateProcessor->setValue('FECHA_INFORME', now()->format('d/m/Y'));
        $templateProcessor->setValue('ELABORADO_POR', 
            $peritaje->perito->nombre . ' ' . $peritaje->perito->apellido);
    }

    private function reemplazarDatosSiniestro($templateProcessor, $siniestro)
    {
        $templateProcessor->setValue('FECHA_HORA_SINIESTRO', 
            $siniestro->fecha_siniestro->format('d/m/Y') . ' - ' . $siniestro->hora_siniestro);
        $templateProcessor->setValue('COMUNA', $siniestro->comuna . ' - ' . $siniestro->region);
        $templateProcessor->setValue('LUGAR_EXACTO', $siniestro->direccion_informada);
        
        // Estado y prioridad (puedes ajustar según tu lógica de negocio)
        $templateProcessor->setValue('ESTADO_SINIESTRO', ucfirst($siniestro->status));
        $templateProcessor->setValue('PRIORIDAD', 'Alta'); // Puedes calcular esto
        $templateProcessor->setValue('TIPO_SINIESTRO', 'Robo con intimidación'); // Ajustar según datos reales
    }

    private function reemplazarParticipantes($templateProcessor, $siniestro)
    {
        // Asegurado
        $templateProcessor->setValue('ASEGURADO_NOMBRE', 
            $siniestro->asegurado->nombre . ' ' . $siniestro->asegurado->apellido);
        $templateProcessor->setValue('ASEGURADO_RUT', 
            $siniestro->asegurado->rut . '-' . $siniestro->asegurado->dv);
        
        // Contratante
        $contratante = $siniestro->contratante ?? $siniestro->asegurado;
        $templateProcessor->setValue('CONTRATANTE_NOMBRE', 
            $contratante->nombre . ' ' . $contratante->apellido);
        
        // Conductor
        $templateProcessor->setValue('CONDUCTOR_NOMBRE', 
            $siniestro->conductor->nombre . ' ' . $siniestro->conductor->apellido);
        
        // Vehículo
        $templateProcessor->setValue('VEHICULO_INFO', 
            $siniestro->vehiculo->marca . ' ' . $siniestro->vehiculo->modelo . ' - ' . $siniestro->vehiculo->patente);
        
        // Relación Asegurado-Conductor
        $templateProcessor->setValue('RELACION_ASEGURADO_CONDUCTOR', 
            $siniestro->relacion_asegurado_conductor);
    }

    private function reemplazarDocumentacion($templateProcessor, $peritaje)
    {
        // Mapear estados de documentos
        $estadosDocumentos = [
            'Parte policial' => 'Pendiente',
            'Licencia de conductor' => 'Pendiente',
            'Permiso de circulación' => 'Pendiente',
            'Seguro obligatorio' => 'Pendiente',
            'Fotos vehículo' => 'Pendiente',
        ];

        // Actualizar con datos reales del checklist
        foreach ($peritaje->checklistDocumentos as $checklistDoc) {
            $nombreDoc = $checklistDoc->documento->nombre;
            if (array_key_exists($nombreDoc, $estadosDocumentos)) {
                $estadosDocumentos[$nombreDoc] = $checklistDoc->cargado ? 'Revisado' : 'Pendiente';
            }
        }

        // Reemplazar en el template
        $templateProcessor->setValue('ESTADO_PARTE_POLICIAL', $estadosDocumentos['Parte policial']);
        $templateProcessor->setValue('ESTADO_LICENCIA', $estadosDocumentos['Licencia de conductor']);
        $templateProcessor->setValue('ESTADO_PERMISO_CIRCULACION', $estadosDocumentos['Permiso de circulación']);
        $templateProcessor->setValue('ESTADO_SEGURO_OBLIGATORIO', $estadosDocumentos['Seguro obligatorio']);
        $templateProcessor->setValue('ESTADO_FOTOS', $estadosDocumentos['Fotos vehículo']);
    }

    private function reemplazarEntrevistas($templateProcessor, $peritaje)
    {
        // Datos de entrevista al asegurado
        $templateProcessor->setValue('ENTREVISTA_ASEGURADO_FECHA', 
            $peritaje->created_at->format('d/m/Y'));
        $templateProcessor->setValue('ENTREVISTA_CONDUCTOR_FECHA', 
            $peritaje->created_at->format('d/m/Y'));

        // Aquí puedes agregar lógica para incluir transcripciones si las tienes
        // Por ahora, dejamos placeholders
        $templateProcessor->setValue('DECLARACION_INICIAL', 
            'Declaración inicial del siniestro según lo reportado a la compañía...');
        
        $templateProcessor->setValue('INFORMACION_RESCATADA_ASEGURADO', 
            'Información relevante obtenida durante la entrevista con el asegurado...');
        
        $templateProcessor->setValue('PUNTOS_CONCORDANTES', 
            'Puntos en los que coinciden las diferentes versiones...');
        
        $templateProcessor->setValue('PUNTOS_DISCORDANTES', 
            'Aspectos donde existen discrepancias en las declaraciones...');
    }
}
