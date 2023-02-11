#!/usr/bin/env php
<?php
declare(strict_types=1);


use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;

$hostname = "0.0.0.0";
$port = 9501;
$server = new Server($hostname, $port);

$server->on('start', function (Server $server) use ($hostname, $port) {
    echo sprintf('Swoole server is started at http://%s:%s' . PHP_EOL, $hostname, $port);
});

$static = [
    'ico'  => 'image/x-icon',
    'html' => 'text/html',
    'css'  => 'text/css',
    'js'   => 'text/javascript',
    'png'  => 'image/png',
    'gif'  => 'image/gif',
    'jpg'  => 'image/jpg',
    'jpeg' => 'image/jpg',
    'mp4'  => 'video/mp4'
];

$server->on(
    "request",
    function (Request $request, Response $response) use ($static) {
        // var_dump($request);

        if (getStaticFile($request, $response, $static)) {
            return;
        }
        if ($request->server['request_uri'] === '/') {
            $response->header('Content-Type', 'text/html');
            $response->sendfile('index.html');
            return;
        }
        if ($request->server['request_uri'] === '/veiculos') {
            $message = '';
            if ($request->server['request_method'] === 'POST') {
                var_dump('getContent', $request->getContent());
                $dados = json_decode($request->getContent());
                $message = 'You post a new veiculo: ' . $dados->veiculo;
            } elseif ($request->server['request_method'] === 'GET') {
                $message = 'You get all veiculos';
            }

            $response->header('Content-Type', 'application/json');
            $response->end(json_encode(['message' => $message]));
            return;
        }
        $response->status(404);
        $response->end();
    }
);

$server->start();

function getStaticFile(
    Request $request,
    Response $response,
    array $static
) : bool {
    $staticFile = __DIR__ . $request->server['request_uri'];
    // var_dump($staticFile);
    if (! file_exists($staticFile)) {
        return false;
    }
    $type = pathinfo($staticFile, PATHINFO_EXTENSION);
    if (! isset($static[$type])) {
        return false;
    }
    $response->header('Content-Type', $static[$type]);
    $response->sendfile($staticFile);
    return true;
}
