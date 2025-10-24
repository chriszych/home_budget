<?php

declare(strict_types=1);

namespace Framework;

class Router
{

    private array $routes = [];
    private array $middlewares = [];
    private array $errorHandler;

    public function add(string $method, string $path, array $controller)
    {

        // $path = $this->normalizePath($path);

        // $regexPath = preg_replace_callback('#{([^/:]+)(?::([^/]+))?}#', function (array $matches) {
        //     $pattern = $matches[2] ?? '[^/]+';
        //     return "({$pattern})";
        // }, $path);

$regexPath = preg_replace_callback('#/{([^/:]+)(?::([^/]+))?}(\?)?#', function ($matches) {
    $paramName = $matches[1];
    $pattern = $matches[2] ?? '[^/]+';
    $isOptional = isset($matches[3]) && $matches[3] === '?';

    return $isOptional
        ? "(?:/({$pattern}))?"
        : "/({$pattern})";
}, $path);

// $regexPath = preg_replace_callback('#({[^}]+})#', function (array $matches) {
//     $segment = $matches[1];

//     $isOptional = str_ends_with($segment, '?');
//     $segment = rtrim($segment, '?');

//     preg_match('#{([^/:]+)(?::([^/]+))?}#', $segment, $parts);
//     $pattern = $parts[2] ?? '[^/]+';

//     return $isOptional
//         ? "(?:/({$pattern}))?"  // cały segment opcjonalny
//         : "/({$pattern})";
// }, $path);


//         $regexPath = preg_replace_callback('#({[^}]+})#', function (array $matches) {
//     $segment = $matches[1];

//     // Sprawdź, czy segment jest opcjonalny (np. kończy się ?)
//     $isOptional = str_ends_with($segment, '?');

//     // Usuń znak zapytania na końcu, jeśli występuje
//     $segment = rtrim($segment, '?');

//     // Dopasuj nazwę i wzorzec
//     preg_match('#{([^/:]+)(?::([^/]+))?}#', $segment, $parts);
//     $pattern = $parts[2] ?? '[^/]+';

//     // Jeśli opcjonalny, opakuj cały segment w (?:/...)?
//     return $isOptional
//         ? "(?:/({$pattern}))?"
//         : "/({$pattern})";
// }, $path);


        //test

        // echo "<pre>";
        // echo "Dodawana trasa: {$path}\n";
        // echo "RegexPath: {$regexPath}\n";
        // echo "</pre>";

        //testEnd


        $this->routes[] = [
            'path' => $path,
            'method' => strtoupper($method),
            'controller' => $controller,
            'middlewares' => [],
            'regexPath' => $regexPath
        ];
    }

    private function normalizePath(string $path): string
    {
        // $path = trim($path, '/');
        // $path = "/{$path}/";
        // $path = preg_replace('#[/]{2,}#', '/', $path);

        //test
        $path = trim($path, '/');
        $path = "/{$path}";
        //testEnd

        return $path;
    }

    public function dispatch(string $path, string $method, ?Container $container = null)
    {
        $path = $this->normalizePath($path);
        $method = strtoupper($_POST['_METHOD'] ?? $method);


        foreach ($this->routes as $route) {

                    //test
//         echo "<pre>";
// echo "Sprawdzana trasa: {$route['path']}\n";
// echo "RegexPath: {$route['regexPath']}\n";
// echo "Żądany path: {$path}\n";
// echo "Metoda: {$method}\n";
// echo "</pre>";
        //testEnd



            if (
                !preg_match("#^{$route['regexPath']}$#", $path, $paramValues) ||
                $route['method'] !== $method
            ) {
                continue;
            }

            array_shift($paramValues);


            //test

//             echo "<pre>";
// echo "Dopasowano trasę: {$route['path']}\n";
// echo "Parametry: " . print_r($paramValues, true) . "\n";
// echo "</pre>";

            //testEnd


            preg_match_all('#{([^/:]+)(?::[^/]+)?}#', $route['path'], $paramKeys);

            $paramKeys = $paramKeys[1];

            //test

            while (count($paramValues) < count($paramKeys)) {
            $paramValues[] = null;
            }

            //testEnd


            $params = array_combine($paramKeys, $paramValues);

            [$class, $function] = $route['controller'];

            $controllerInstance = $container ?
                $container->resolve($class) :
                new $class;
            //Test

            // echo "Matched route: {$route['path']}<br>";
            // echo "Params: " . json_encode($params) . "<br>";

            //endTest    


            $action = fn() => $controllerInstance->{$function}($params);

            $allMiddleware = [...$route['middlewares'], ...$this->middlewares];

            foreach($allMiddleware as $middleware){
                $middlewareInstance = $container ?
                    $container->resolve($middleware) : 
                    new $middleware;
                $action = fn() => $middlewareInstance->process($action);
            }

            $action();

            return;
        }

        $this->dispatchNotFound($container);
    }

    public function addMiddleware(string $middleware) {
        $this->middlewares[] = $middleware;
    }

    public function addRouteMiddleware(string $middleware){
        $lastRouteKey = array_key_last($this->routes);
        $this->routes[$lastRouteKey]['middlewares'][] = $middleware;
    }

    public function setErrorHandler(array $controller)
    {
        $this->errorHandler = $controller;
    }

    public function dispatchNotFound(?Container $container)
    {
        [$class, $function] = $this->errorHandler;

        $controllerInstance = $container ? $container->resolve($class) : new $class;

        $action = fn () => $controllerInstance->$function();

        foreach ($this->middlewares as $middleware) {
            $middlewareInstance = $container ? $container->resolve($middleware) : new $middleware; 

            $action = fn () => $middlewareInstance->process($action);
        }

        $action();
    }
}
