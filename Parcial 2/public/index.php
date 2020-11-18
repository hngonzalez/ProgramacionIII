<?php

require __DIR__.'/vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

use App\Controllers\UserController;
use App\Controllers\MateriaController;
use App\Controllers\StatsController;
use App\Controllers\InscripcionController;
use App\Controllers\NotasController;

use App\Middlewares\JsonMiddleware;
use App\Middlewares\userLoginMiddleware;
use App\Middlewares\AdminMiddleware;
use App\Middlewares\AlumnoMiddleware;
use App\Middlewares\ProfesorMiddleware;

use Config\Database;

$app = AppFactory::create();
$app->setBasePath("/progIII/parcial 2/public");
$app->addRoutingMiddleware();

new Database;

/**
 * Grupo de rutas donde dividiremos Registro, Login y un grupo dedicado a rutas para usuarios logeados
 * 
 */
$app->group('', function (RouteCollectorProxy $group) {

    $group->post('/users', UserController::class.":userSignUp");
    
    $group->post('/login', UserController::class.":userLogIn");

    $group->group('', function (RouteCollectorProxy $groupUser) {

        $groupUser->post('/materia', MateriaController::class.":addMateria")->add(new userLoginMiddleware)->add(new AdminMiddleware);

        $groupUser->post('/inscripcion/{idMateria}', InscripcionController::class.":addInscripcion")->add(new userLoginMiddleware)->add(new AlumnoMiddleware);

        //$groupUser->put('/notas/{idMateria}', NotasController::class.":addNota")->add(new userLoginMiddleware)->add(new ProfesorMiddleware);

        $groupUser->get('/inscripcion/{idMateria}', InscripcionController::class.":listoInscriptos")->add(new userLoginMiddleware)->add(new ProfesorMiddleware)->add(new AdminMiddleware);
        
        $groupUser->get('/materia', StatsController::class.":listadoMaterias")->add(new userLoginMiddleware);

        //$groupUser->get('/notas/{idMateria}', StatsController::class.":listadoMaterias");
    
    });

})->add(new JsonMiddleware);

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$app->run();



?>


