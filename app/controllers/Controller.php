<?php

namespace App\Controllers;

//de esta manera accedemos a las funciones de los trit en las vistas
use Lib\Csrf;
use Lib\Utils;

class Controller{

    use Csrf, Utils;

    public function view($route, $data = []) 
    {
        //destructurar el array. Nos permite poner las variables de $data en el html
        extract($data);

        $route = str_replace('.','/',$route);

        if(file_exists("../resources/views/{$route}.php"))
        {
            ob_start();
            include "../resources/views/{$route}.php";
            $content = ob_get_clean();

            return $content;
        }else{
            return "El archivo no existe";
        }
    }

    public function redirect($route){
        return header("Location: {$route}");
    }

    public function headJson()
    {
        return header("Content-Type: application/json");
    }
}