<?php

namespace App\Core;

class Router
{
    public static function dispatch($uri)
    {
        $routesPath = __DIR__ . '/../../routes/web.php';

        if (!file_exists($routesPath)) {
            http_response_code(500);
            echo "Arquivo de rotas não encontrado.";
            exit;
        }

        $routes = require $routesPath;

        foreach ($routes as $route => $action) {
            $pattern = str_replace('/', '\/', $route);
            $pattern = '/^' . preg_replace('/\{[^}]+\}/', '([^\/]+)', $pattern) . '$/';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                if (is_callable($action)) {
                    call_user_func_array($action, $matches);
                } elseif (is_string($action)) {
                    list($controller, $method) = explode('@', $action);
                    $controllerClass = 'App\\Controllers\\' . $controller;

                    if (class_exists($controllerClass)) {
                        $controllerInstance = new $controllerClass();
                        if (method_exists($controllerInstance, $method)) {
                            call_user_func_array([$controllerInstance, $method], $matches);
                        } else {
                            http_response_code(500);
                            echo "Método {$method} não encontrado em {$controllerClass}.";
                        }
                    } else {
                        http_response_code(500);
                        echo "Controlador {$controllerClass} não encontrado.";
                    }
                }
                return;
            }
        }

        http_response_code(404);
        echo "Página não encontrada.";
    }
}
