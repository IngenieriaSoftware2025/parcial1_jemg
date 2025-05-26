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
        $router->render('asistencias/index', []);
    }
}