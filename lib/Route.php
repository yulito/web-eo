<?php

namespace Lib;

class Route
{
    //Lo que harán las siguientes funciones es relacionar la url (a traves de la uri) con la funcion correspondiente segun las rutas en web.php
    //ojo esta $uri en realidad en la ruta declarada en web.php
    private static $routes = [];

    public static function get($uri, $callback)
    {
        $uri = trim($uri,'/');
        self::$routes['GET'][$uri] = $callback;
    }

    public static function post($uri, $callback)
    {
        $uri = trim($uri,'/');
        self::$routes['POST'][$uri] = $callback;
    }
    
    //Digamos que esta funcion es el motor que hara trabajar las funciones anteriores
    //aca obtenemos la $uri real para compararla con la que obtuvimos con las funciones get y post de aqui arriba.
    public static function dispatch()
    {
        $uri = $_SERVER['REQUEST_URI'];
        //echo $uri;
        $uri = trim($uri,'/');

        $method = $_SERVER['REQUEST_METHOD'];

        foreach(self::$routes[$method] as $route => $callback){

            if(strpos($route,':') !== false)
            {
                $route = preg_replace('#:[a-zA-Z]+#','([a-zA-Z0-9]+)',$route);                
            }

            if(preg_match("#^$route$#", $uri, $matches))
            {
                $params = array_slice($matches,1);              
                if(is_callable($callback)){
                    $response = $callback(...$params);
                }

                if(is_array($callback)){
                    $controller = new $callback[0];
                    $response = $controller->{$callback[1]}(...$params);
                }

                if(is_array($response) || is_object($response)){

                    header('Content-Type: application/json');

                    echo json_encode($response);
                }else{
                    echo $response;
                }

                return;
            }           
        }
        echo '404 Not Found';
    }


}