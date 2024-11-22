<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Proyecto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // directorio 'public/documents' 
        Storage::disk('public')->makeDirectory('documentos');

        // nombre de los documentos
        $plantillaFiles = [
            'CARTA ASIGNACION DE TUTOR.docx',
            'Constancia de aprobación del Plan de Trabajo del Servicio Social.docx',
            'Constancia de Finalización del Servicio Social.docx',
            'Constancia de la Institución.docx',
            'Constancia del Docente Tutor de Servicio Social.docx',
            'Control de Asesorías a estudiantes en Servicio Social.docx',
            'Control de Asistencia.docx',
            'EJEMPLO DE DOCUMENTACION PARA EL PROYECTO DE SERVICIO SOCIAL.docx',
            'Ficha de desempeño del estudiante en Servicio Social.docx',
            'Ficha de supervisión y evaluación del Servicio Social.docx',
            'FORMULARIO N1 HOJA DE INSCRIPCION PARA SERVICIO SOCIAL.docx',
            'Formulario Nº 8 Formulario 3-5 Para El MINED.docx',
            'Informe del 50% del Servicio Social.docx',
            'Informe del 100% del Servicio Social.docx',
            'Manual de proyeccion social.doc',
            'MODELO DE CARTA A LA INSTITUCION QUE SOLICITA ESTUDIANTES EN SERVICIO SOCIAL.docx',
            'Modelo de Certificación.docx',
        ];

        
        $proyectos = Proyecto::all();

        foreach ($plantillaFiles as $file) {
            // Ruta del archivo en el almacenamiento local
            $sourcePath = storage_path('app/public/documentos/' . $file);  // Ruta de los archivos en el almacenamiento local
            // Ruta de destino en el almacenamiento público
            $destinationPath = 'documentos/' . $file;
            
            if (file_exists($sourcePath)) {
                // Copiar el archivo al almacenamiento público
                Storage::disk('public')->put($destinationPath, file_get_contents($sourcePath));
                
                // Crear URL pública del archivo almacenado
                $url = Storage::url($destinationPath);

                // Seleccionar un id_proyecto aleatorio
                $id_proyecto = $proyectos->random()->id_proyecto;

                // Insertar el registro en la base de datos
                DB::table('documentos')->insert([
                    'id_proyecto' => $id_proyecto,
                    'tipo_documento' => pathinfo($file, PATHINFO_EXTENSION),
                    'ruta_archivo' => $url,
                    'fecha_subida' => Carbon::now(),
                    //'created_at' => Carbon::now(),
                    //'updated_at' => Carbon::now(),
                ]);

                $this->command->info("Archivo '{$file}' copiado a storage/app/public/{$destinationPath} y URL guardada en la base de datos con id_proyecto {$id_proyecto}.");
            } else {
                $this->command->warn("El archivo '{$file}' no existe en la carpeta storage/app/public/documents.");
            }
        }
    }
}
