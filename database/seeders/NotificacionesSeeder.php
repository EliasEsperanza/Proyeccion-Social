<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
                try {
            // Obtener todos los estudiantes
            $estudiantes = Estudiante::with('usuario')->get();

            if ($estudiantes->isEmpty()) {
                throw new \Exception('Debes crear estudiantes antes de crear notificaciones');
            }

            $mensajes = [
                'Bienvenido al sistema de horas sociales',
                'Tu registro de horas ha sido actualizado',
                'Hay nuevas oportunidades de servicio social disponibles',
                'Recordatorio: Actualiza tu perfil de estudiante',
                'Tu departamento ha publicado nuevas oportunidades',
                'Recordatorio de completar documentación pendiente',
                'Nueva actividad disponible en tu sección',
                'Se ha aprobado tu solicitud de horas sociales',
                'Tienes documentos pendientes por revisar',
                'Actualización importante del sistema'
            ];

            // Las notificaciones para los estudiantes 
            foreach ($estudiantes as $estudiante) {
                
                $numNotificaciones = rand(3, 8);
                
                for ($i = 0; $i < $numNotificaciones; $i++) {
                    Notificacion::create([
                        'id_usuario' => $estudiante->id_usuario,
                        'mensaje' => $mensajes[array_rand($mensajes)],
                        'estado' => rand(0, 1), 
                        'fecha_envio' => Carbon::now()->subDays(rand(0, 30))->format('Y-m-d H:i:s')
                    ]);
                }
            }

        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
            throw $e;
        }
    }
}
