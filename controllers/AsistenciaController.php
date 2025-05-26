<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use Model\Asistencias;
use Model\Actividades;
use MVC\Router;

class AsistenciaController extends ActiveRecord
{

    public static function renderizarPagina(Router $router)
    {
        // Obtener actividades de la base de datos
        $actividades = Actividades::all();

        // Renderizar la vista de asistencias y enviar actividades
        $router->render('asistencias/index', [
            'actividades' => $actividades
        ]);
    }

    public static function guardarAPI()
    {

        getHeadersApi();

        // Generar automáticamente la hora actual de llegada
        $asistencia_hora_llegada = date('Y-m-d H:i:s');

        try {

            $data = new Asistencias([
                'actividad_id' => $_POST['actividad_id'],
                'asistencia_hora_llegada' => $asistencia_hora_llegada,
                'asistencia_situacion' => 1
            ]);

            $crear = $data->crear();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Exito la asistencia ha sido registrada correctamente con hora: ' . date('d/m/Y H:i:s')
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarAPI()
    {
        try {
            $fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
            $fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;
            $actividad_id = isset($_GET['actividad_id']) ? $_GET['actividad_id'] : null;

            $condiciones = ["asi.asistencia_situacion = 1"];

            if ($fecha_inicio) {
                $condiciones[] = "DATE(asi.asistencia_hora_llegada) >= '{$fecha_inicio}'";
            }

            if ($fecha_fin) {
                $condiciones[] = "DATE(asi.asistencia_hora_llegada) <= '{$fecha_fin}'";
            }

            if ($actividad_id) {
                $condiciones[] = "asi.actividad_id = {$actividad_id}";
            }

            $where = implode(" AND ", $condiciones);

            $sql = "SELECT 
                        asi.asistencia_id,
                        asi.actividad_id,
                        asi.asistencia_hora_llegada,
                        act.actividad_nombre,
                        act.actividad_hora_esperada,
                        CASE 
                            WHEN asi.asistencia_hora_llegada <= act.actividad_hora_esperada 
                            THEN 'Puntual' 
                            ELSE 'Tarde' 
                        END AS estado_puntualidad
                    FROM asistencias asi
                    JOIN actividades act ON asi.actividad_id = act.actividad_id
                    WHERE $where
                    ORDER BY asi.asistencia_hora_llegada DESC";
            
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Asistencias obtenidas correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las asistencias',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {

        getHeadersApi();

        $id = $_POST['asistencia_id'];
        // Mantener la hora original, solo permitir cambiar la actividad
        
        try {

            $data = Asistencias::find($id);
            $data->sincronizar([
                'actividad_id' => $_POST['actividad_id'],
                // No modificamos asistencia_hora_llegada para mantener la hora original
                'asistencia_situacion' => 1
            ]);
            $data->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La actividad de la asistencia ha sido modificada exitosamente (hora original mantenida)'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al guardar',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function EliminarAPI()
    {

        try {

            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

            $ejecutar = Asistencias::EliminarAsistencias($id);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El registro ha sido eliminado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al Eliminar',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

}