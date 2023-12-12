<?php

namespace Lib;

use Lib\Session;

trait Csrf{

    use Session; //usamos las funciones de trait Session

    //Generar token
    public function createTokenCsrf()
    {
        //creamos contenido del token
        $token = bin2hex(openssl_random_pseudo_bytes(32));

        //creamos la sesion del token
        $this->Session('token', $token);

        //obtenemos el token
        return $this->getSession('token');
    }

    //validar token
    public function validateToken($token)
    {
        if($this->ExistSession('token') && $this->getSession('token') == $token)
        {
            return true;
        }else{
            header($_SERVER['SERVER_PROTOCOL'].'405 Method Not Allowed');
            exit;
        }
    }
}