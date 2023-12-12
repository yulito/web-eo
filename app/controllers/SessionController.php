<?php

namespace App\Controllers;

use App\Models\User;
use App\Helpers\Msg;

class SessionController extends Controller{

    public function login(){
        //header para json
        $this->headJson();

        $email = isset($_POST['email']) ? $_POST['email'] : NULL;
        $password = isset($_POST['password']) ? $_POST['password'] : NULL;
        
        $msg['msg'] = [];

        if(empty($email) || empty($password)){
            $msg['msg']['field'] = Msg::EMPTY_FIELD;             
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $msg['msg']['email'] = Msg::EMAIL_FORMAT;
        }
        
        if(empty($msg['msg'])){
            
            $user = new User();
            $user->setEmail($email);

            //validar contraseña con metodo de model
            $login = $user->enter($password); 

            //resultado segun validacion
            if($login) {

                $_SESSION['auth'] = $login;                
                $msg['msg']['welcome'] = Msg::WELCOME.' '.$login->name;                

            }
            if($login == ''){
                $msg['msg']['auth_error'] = Msg::AUTH_ERROR;                         
            }

            echo  json_encode($msg['msg']);

        }else{
            echo json_encode($msg['msg']);
        } 
    }

    public function logout()
    {
        unset($_SESSION['auth']);
        return $this->redirect('/');
    }
}