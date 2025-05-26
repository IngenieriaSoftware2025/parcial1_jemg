<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use Model\Asistencias;
use Model\Actividades;
use MVC\Router;

class AsistenciaController extends ActiveRecord
{

      public static function renderizarPagina(Router $router){
        // Obtener categorías de la base de datos
        $actividades = Actividades::all();

        // Renderizar la vista de productos y enviar categorías
        $router->render('asistencias/index', [
            'actividades' => $actividades
        ]);
    }
}