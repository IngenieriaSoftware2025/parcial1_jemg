<?php 
require_once __DIR__ . '/../includes/app.php';

use Controllers\ActividadController;
use Controllers\AsistenciaController;
use MVC\Router;
use Controllers\AppController;
$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class,'index']);


//RUTAS PARA ACTIVIDADES
$router->get('/actividades', [ActividadController::class, 'renderizarPagina']);
$router->post('/actividades/guardarAPI', [ActividadController::class, 'guardarAPI']);
$router->get('/actividades/buscarAPI', [ActividadController::class, 'buscarAPI']);
$router->post('/actividades/modificarAPI', [ActividadController::class, 'modificarAPI']);
$router->get('/actividades/eliminar', [ActividadController::class, 'EliminarAPI']);

//RUTAS PARA ASISTENCIAS
$router->get('/asistencias', [AsistenciaController::class, 'renderizarPagina']);
$router->post('/asistencias/guardarAPI', [AsistenciaController::class, 'guardarAPI']);
$router->get('/asistencias/buscarAPI', [AsistenciaController::class, 'buscarAPI']);
$router->post('/asistencias/modificarAPI', [AsistenciaController::class, 'modificarAPI']);
$router->get('/asistencias/eliminar', [AsistenciaController::class, 'EliminarAPI']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
