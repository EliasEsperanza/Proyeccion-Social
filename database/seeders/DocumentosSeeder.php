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
            'Carta_de_Ampliacion_de_Tiempo-2024.docx',
            'Carta_de_Eliminacion_de_Estudiante_del_Proyecto_(grupo)-2024.docx',
            'Carta_de_Eliminacion_de_un_estudiante_(estudiante)-2024.docx',
            'Carta_de_Eliminacion-2024.docx',
            'Carta_de_Prorroga_a_Jefe_de_Unidad-2024.docx',
            'Carta_de_solicitud.docx',
            'Cartas_para_Inscripcion.docx',
            'Formato_de_Inscripcion.docx',
            'Formato_de_Memoria.docx',
            'Formato_de_Proyecto.docx',
            'HOJA_DE_VIDA_bolsa_de_trabajo_UES.docx',
            'MANUALDEPROYECCIONSOCIAL_LINIAMIENTOS.docx',
            'MANUALDEPROYECCIONSOCIAL.doc',
            //'MANUALDEPROYECCIONSOCIAL.doc',
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
