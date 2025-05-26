<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use Model\Actividades;
use MVC\Router;

class ActividadController extends ActiveRecord
{

    public static function renderizarPagina(Router $router)
    {
        $router->render('actividades/index', []);
    }

    public static function guardarAPI()
    {

        getHeadersApi();


        $_POST['actividad_nombre'] = ucwords(strtolower(trim(htmlspecialchars($_POST['actividad_nombre']))));
        $_POST['actividad_hora_esperada'] = date ('Y-m-d H:i:s', strtotime($_POST['actividad_hora_esperada']));

            try {

                // $data = new Actividades();

                $data = new Actividades([
                    'actividad_nombre' => $_POST['actividad_nombre'],
                    'actividad_hora_esperada' => $_POST['actividad_hora_esperada'],
                    'actividad_situacion' => 1
                ]);

                $crear = $data->crear();

                http_response_code(200);
                echo json_encode([
                    'codigo' => 1,
                    'mensaje' => 'Exito la actividad ha sido registrada correctamente'
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

            
            $condiciones = ["actividad_situacion = 1"];

            
            if ($fecha_inicio) {
                $condiciones[] = "actividad_hora_esperada >= '{$fecha_inicio} 00:00'";
            }

            if ($fecha_fin) {
                $condiciones[] = "actividad_hora_esperada <= '{$fecha_fin} 23:59'";
            }

            
            $where = implode(" AND ", $condiciones);

            
            $sql = "SELECT * FROM actividades WHERE $where";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Actividades obtenidas correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las actividades',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {

        getHeadersApi();

        $id = $_POST['actividad_id'];
        $_POST['actividad_nombre'] = ucwords(strtolower(trim(htmlspecialchars($_POST['actividad_nombre']))));
        $_POST['actividad_hora_esperada'] = date ('Y-m-d H:i:s', strtotime($_POST['actividad_hora_esperada']));
            try {


                $data = Actividades::find($id);
                // $data->sincronizar($_POST);
                $data->sincronizar([
                    'actividad_nombre' => $_POST['actividad_nombre'],
                    'actividad_hora_esperada' => $_POST['actividad_hora_esperada'],
                    'actividad_situacion' => 1
                ]);
                $data->actualizar();

                http_response_code(200);
                echo json_encode([
                    'codigo' => 1,
                    'mensaje' => 'La informacion de la actividad ha sido modificada exitosamente'
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

            $ejecutar = Actividades::EliminarActividades($id);


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