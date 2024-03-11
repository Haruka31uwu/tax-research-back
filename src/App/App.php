<?php

use \DI\Container;
use Slim\Factory\AppFactory;
use Slim\Exception\HttpNotFoundException;

require __DIR__ . '/../../vendor/autoload.php';


//Crea el contenedor usando PHP-DI.
$container = new Container();

//Agrega el contenedor para crear la aplicación en AppFactory.
AppFactory::setContainer($container);
$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$container = $app->getContainer();

//Define la ruta base. (Se agrega solo si no tiene un VirtualHost creado).
$app->setBasePath('/slim4-crud');

//Agrega Middleware de enrutamiento.

//Se define la zona horaria para obtener la fecha y hora correcta. 
date_default_timezone_set('America/Santiago');


require __DIR__ . "/Configs.php";
require __DIR__ . "/Dependencies.php";
require __DIR__ . "/Loggers.php";


$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
            ->withHeader('Access-Control-Allow-Origin', 'http://localhost:3000')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});
$app->group('/api', function ($app) {
    //Rutas para el recurso "client".
    $app->group('/client', function ($app) {
        $app->post('/getAll', 'App\Controllers\ClientController:getAll');
        $app->post('/insert', 'App\Controllers\ClientController:insert');
        $app->post('/update', 'App\Controllers\ClientController:update');
        $app->post('/delete', 'App\Controllers\ClientController:delete');
    });
});
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
    throw new HttpNotFoundException($request);
});

$logger = $container->get('logger_files');
$errorMiddleware = $app->addErrorMiddleware(true, true, true, $logger);

//Se inicia la aplicación.
$app->run();