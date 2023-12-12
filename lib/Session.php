<?php

namespace Lib;


trait Session{

    // creamos la variable de sesión
    public function Session(string $session_name, $value)
    {
        $_SESSION[$session_name] = $value;
    }

    // obtenemos la variable de sesión
    public function getSession(string $session_name)
    {
        return isset($_SESSION[$session_name]) ? $_SESSION[$session_name]: "";
    }

    // devolvemos un true si existe la variable sesión
    public function ExistSession(string $session_name)
    {
        return isset($_SESSION[$session_name]);
    }

    // Eliminamos variable sesión
    public function destroySession(string $session_name)
    {
        if($this->ExistSession($session_name))
        {
            unset($_SESSION[$session_name]);
        }
    }
}