<?php

namespace App;

use Swoole\Http\Request;
use Swoole\Http\Response;

class Router
{
    public const METHOD_GET = 'GET';
    public const  METHOD_POST = 'POST';
    public const  METHOD_PUT = 'PUT';

    private $static = [
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

    private $routes = [];

    public function get($route, $controller)
    {
        $this->routes[self::METHOD_GET][$route] = $controller;
    }

    public function post($route, $controller)
    {
        $this->routes[self::METHOD_POST][$route] = $controller;
    }

    public function put($route, $controller)
    {
        $this->routes[self::METHOD_PUT][$route] = $controller;
    }

    public function getController($route, $method)
    {
        if (isset($this->routes[$method][$route])) {
            return $this->routes[$method][$route];
        }
        return null;
    }

    public function resolve(Request $request, Response $response)
    {
        $method = $request->server['request_method'];
        $route = $request->server['request_uri'];

        var_dump($method, $route);
        if ($method !== self::METHOD_GET && $method !== self::METHOD_POST && $method !== self::METHOD_PUT) {
            $this->returnMethodNotAllowed($response);
            return;
        }

        if ($method === self::METHOD_GET) {
            //check for static files
            $file = __DIR__ . '/../public' . $route;

            $type = pathinfo($file, PATHINFO_EXTENSION);
            if ($this->isStaticFile($file, $type)) {
                $this->returnStaticFile($file, $type, $response);
                return;
            }
        }

        //check for routes
        $controller = $this->getController($route, $method);
        if (is_null($controller)) {
            $this->returnNotFound($response);
            return;
        }

        try {
            if (is_array($controller) && count($controller) == 2 && class_exists($controller[0])) {
                $obj = new $controller[0]();
                $obj->{$controller[1]}($request, $response);
                return;
            }
            if (is_callable($controller)) {
                call_user_func($controller, $request, $response);
                return;
            }
        } catch (\Error $e) {
            $response->status(500);
            $response->end('Server Error');
        }
    }

    private function isStaticFile($file, $type): bool
    {
        if (! file_exists($file)) {
            return false;
        }

        if (! isset($this->static[$type])) {
            return false;
        }
        return true;
    }

    private function returnStaticFile($file, $type, Response $response)
    {
        $response->header('Content-Type', $this->static[$type]);
        $response->sendfile($file);
    }

    private function returnMethodNotAllowed(Response $response)
    {
        $response->status(405);
        $response->end(json_encode(['error' => "Method not allowed"]));
    }

    private function returnNotFound(Response $response)
    {
        $response->status(404);
        $response->end("<h1>Resource not Found</h1>");
    }
}
