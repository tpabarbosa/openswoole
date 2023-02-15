#!/usr/bin/env php
<?php
declare(strict_types=1);
require __DIR__ . '/vendor/autoload.php';
require_once 'config.php';

use App\Router;
use App\VeiculosController;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;

$hostname = "0.0.0.0";
$port = 9501;
$server = new Server($hostname, $port);

$router = new Router();
$router->get('/', function (Request $request, Response $response) {
    $response->header('Content-Type', 'text/html');
    $response->sendfile(__DIR__ . '/public/index.html');
});

$router->get('/veiculos', [VeiculosController::class, 'getAll']);

$router->post('/veiculos', [VeiculosController::class, 'create']);

$router->get('/veiculos/find', [VeiculosController::class, 'find']);

$router->put('/veiculos/update', [VeiculosController::class, 'update']);

$server->on('start', function (Server $server) use ($hostname, $port) {
    echo sprintf('Swoole server is started at http://%s:%s' . PHP_EOL, $hostname, $port);
});

$server->on(
    "request",
    function (Request $request, Response $response) use ($router) {
        try {
            $router->resolve($request, $response);
        } catch (Exception $e) {
            $response->status(500);
            $response->end("Server Error");
        }
    }
);

$server->start();
