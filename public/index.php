<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\APIController;
use Controllers\CitasController;
use Controllers\LoginController;
use Controllers\ServicioController;
use MVC\Router;

$router = new Router();

/************************************INICIO AUTH************************************** */
//iniciar sesio
$router -> get( '/', [LoginController::class, 'login']);
$router -> post( '/', [LoginController::class, 'login']);

//CERRAR SESION
$router -> get( '/logout', [LoginController::class, 'logout']);

//recuperar password
$router -> get( '/recuperar', [LoginController::class, 'recuperar']);
$router -> post( '/recuperar', [LoginController::class, 'recuperar']);

//comprobarcorreo
$router -> get( '/cambiar-password', [LoginController::class, 'cambiarPassword']);
$router -> post( '/cambiar-password', [LoginController::class, 'cambiarPassword']);

//crear cuenta

$router -> get( '/crear-cuenta', [LoginController::class, 'crear']);
$router -> post( '/crear-cuenta', [LoginController::class, 'crear']);

//recuperar cuenta
$router -> get( '/confirmar-cuenta', [LoginController::class, 'confirmar']);
$router -> post( '/confirmar-cuenta', [LoginController::class, 'confirmar']);

//mensaje 
$router -> get( '/mensaje', [LoginController::class, 'mensaje']);



/************************************FIN AUTH************************************** */

/***************************************************ARENAS PRIVADAS************************************************ */

/*********************API de  citas************************* */

$router -> get( '/api/servicios', [APIController::class, 'index']);
$router -> post('/api/citas' , [APIController::class, 'guardar']);
$router -> post('/api/eliminar' , [APIController::class, 'eliminar']);


/********************FIN API********************** */


/*******************CITAS************************* */

$router -> get( '/citas', [CitasController::class, 'citas']);
$router -> post( '/citas', [CitasController::class, 'citas']);

/*******************FIN CITAS********************* */


/*******************ADMIN******************************************************* */

$router -> get( '/admin', [AdminController::class, 'index']);

/*******************crud************************* */
$router -> get( '/servicios', [ServicioController::class, 'index']);

$router -> get( '/servicios/crear', [ServicioController::class, 'crear']);
$router -> post( '/servicios/crear', [ServicioController::class, 'crear']);

$router -> get( '/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router -> post( '/servicios/actualizar', [ServicioController::class, 'actualizar']);

$router -> post( '/servicios/eliminar', [ServicioController::class, 'eliminar']);



/*******************fin crud************************* */


/**********************************FIN ADMIN*****************************************/

/************************************************FIN ARENAS PRIVADAS************************************************ */







// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();