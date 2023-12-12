<?php

namespace App\Controllers;

use App\Helpers\Msg;
use App\Models\User;
use App\Models\Publication;
use App\Models\Email;

class UserController extends Controller{

    public function index()
    {
        if(isset($_SESSION['auth'])){
            return $this->redirect("/");
        }else{
            return $this->view('register.register'); 
        }
    }

    public function store()
    {
        //cabecera json en caso de utilizarla
        $this->headJson();

        //---- Validar token
        $this->validateToken($_POST['token_']);

        $name   = !empty($_POST['name'])     ? $_POST['name']       : NULL;
        $email  = !empty($_POST['email'])    ? $_POST['email']      : NULL;
        $date   = !empty($_POST['date'])     ? $_POST['date']       : NULL;
        $photo  = !empty($_FILES['photo'])   ? $_FILES['photo']     : NULL;
        $pass   = !empty($_POST['password']) ? $_POST['password']   : NULL;

        //---- Almacenar errores
        $msg['msg'] = [];
        if($name == null || $email == null || $date == null || $pass == null)
        {            
            $msg['msg']['field'] = Msg::EMPTY_FIELD;            
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
            $msg['msg']['email'] = Msg::EMAIL_FORMAT;
        }

        if(strlen($pass) > 8 || strlen($pass) < 4){
            $msg['msg']['pass'] = Msg::PASS_LENGTH;
        }
        //---- Enviar errores
        if(!empty($msg['msg']))
        {            
            echo json_encode($msg['msg']);

        }else{            
            //---- Almacenar foto 
            $namePhoto = null;
            
            if(!is_null($photo)){
                $mimetype   = $photo['type'];                

                if($mimetype == "image/jpg" || $mimetype == 'image/jpeg' || $mimetype == 'image/png' || $mimetype == 'image/gif')
                {
                    /*
                        No podemos abrir un archivo de imagen desde un directorio externo a public ya que
                        el index.php no posee ningun archivo para linkear el path de la imagen almacenada, 
                        para ello se debe, o bien, crear un link que apunte al directorio externo o, lo que haremos en 
                        este caso, crear un directorio dentro de public que nos permita almacenar imagenes o archivos.
                    */
                    
                    if(!is_dir('uploads/user')){
                        mkdir('uploads/user', 0777, true);
                    }
                    $namePhoto  = date("d-m-Y").'_'.$name.'_'.$photo['name'];
                    move_uploaded_file($photo['tmp_name'], 'uploads/user/'.$namePhoto);                                        

                }                
            }

                //---- Almacenar datos en BD
                $user = new User();
                //valida email y name existentes (false = sin tomar en cuenta si tenemos uns session hecha)
                if($user->emailExist($email, false)){
                    $msg['msg']['email_exist'] = Msg::EMAIL_EXIST;                
                }
                if($user->nameExist($name, false)){
                    $msg['msg']['name_exist'] = Msg::NAME_EXIST;
                }
                if(empty($msg['msg'])){
                $user->setName($name);
                $user->setBirth_date($date);
                $user->setPhoto($namePhoto);
                $user->setEmail($email);
                $user->setPassword($pass);
                $save = $user->insert();

                $msg['msg']['success'] = Msg::MSG_SUCCESS;
                }

                echo json_encode($msg['msg']);                                        
            }             
    }

    public function recovery()
    {
        if(isset($_SESSION['auth'])){
            return $this->redirect("/");
        }else{
            return $this->view('register.recovery'); 
        }               
    }

    public function sendMailRecovery()
    {
        $this->headJson();

        //---- Validar token
        $this->validateToken($_POST['token_']);

        $email = !empty($_POST['email']) ? $_POST['email']: NULL;

        $msg['msg'] = [];
        if($email == null)
        {            
            $msg['msg']['error'] = Msg::ERR_MAIL_SEND;
            echo json_encode($msg['msg']);
        }
        else{
            $user = new User();
            $user->setEmail($email);
            $val = $user->emailVerifyToken();
        
            if($val == false)
            {            
                $msg['msg']['error'] = Msg::ERR_MAIL_SEND;
            }else{

                //aqui llamaremos al obj de Mail
                $mailSend = new Email();
                $return = $mailSend->sendMail($email, $val);

                //$msg['msg'] = [];
                if($return){
                    $msg['msg']['success'] = Msg::EMAIL_SEND;
                    echo json_encode($msg['msg']);
                    exit;
                }
                else{
                    $msg['msg']['error'] = Msg::ERR_MAIL_SEND;
                    echo json_encode($msg['msg']);
                    exit;
                }                
            }
            echo json_encode($msg['msg']);
        }                
    }

    public function changePass()
    {
        if(isset($_SESSION['auth'])){
            return $this->redirect("/");
        }else{
            return $this->view('register.changepass');
        }                
    }

    public function editPass()
    {
        $this->headJson();

        //---- Validar token
        $this->validateToken($_POST['token_']);

        $token      =  !empty($_POST['tokenPass']) ? $_POST['tokenPass'] : NULL;
        $password   =  !empty($_POST['password']) ? $_POST['password'] : NULL;
        $passRepeat =  !empty($_POST['passwordRepeat']) ? $_POST['passwordRepeat'] : NULL;

        $msg['msg'] = [];
        if($token == null || $password == null || $passRepeat == null)
        {
            $msg['msg']['field'] = Msg::ALL_FIELDS;
        }
        if(strlen($password) > 8 || strlen($password) < 4){
            $msg['msg']['pass1'] = Msg::PASS_LENGTH;
        }
        if(strlen($passRepeat) > 8 || strlen($passRepeat) < 4){
            $msg['msg']['pass2'] = Msg::PASS_LENGTH;
        }
        if($password != $passRepeat){
            $msg['msg']['notmatch'] = Msg::PASS_NOTMATCH;
        }

        if(!empty($msg['msg']))
        {
           echo json_encode($msg['msg']);
           exit;

        }else{
            $user = new User();
            $user->setPassword($password);
            $result = $user->refreshPassword($token);
            if($result)
            {
                $msg['msg']['success'] = Msg::MSG_SUCCESS;                
            }else{
                $msg['msg']['error'] = Msg::FAILED_OPERATION;
            }
            echo json_encode($msg['msg']);            
        }
    }

    public function show($name)
    {
        $user = new User();
        $resultUser = $user->getUserByName($name);

        $pub = new Publication();
        //si existe la sesion usuario y si su rol es 4 y ademas el perfil usa el mismo nombre que usuario...
        if(isset($_SESSION['auth']) && $_SESSION['auth']->id_rol == 4 && $_SESSION['auth']->name == $name){
            $objs = $pub->getAll(false, false, $name, false);
        }else{
        //de lo contrario solo tengan accesso a los chistes publicados
            $objs = $pub->getAll(2, false, $name, false);
        }        
        if($objs && $resultUser){
            return $this->view('profile',['obj'=>$objs, 'user'=>$resultUser]);
        }else{
            return $this->view('profile',['empty'=>'No hay nada para mostrar']);
        }         
    }

    public function showAllUsers(){
        if(isset($_SESSION['auth'])){
            $users = new User();
            if($_SESSION['auth']->id_rol == 3){
                $obj = $users->getAll(4);
            }
            if($_SESSION['auth']->id_rol == 1){
                $obj = $users->getAll(false);
            }

            if($obj){
                return $this->view('users', ['obj'=> $obj]);
            }else{
                return $this->view('users', ['msg'=> 'No hay usuarios registrados.']);
            }
        }
    }

    public function showProfileEdit()
    {
        if(!isset($_SESSION['auth'])){
            return $this->redirect("/");
        }else{
            return $this->view('profileEdit'); 
        }
    }

    public function update()
    {
        $this->headJson();
        $this->validateToken($_POST['token_']);

        $name = !empty($_POST['name']) ? $_POST['name'] : NULL;
        $email = !empty($_POST['email']) ? $_POST['email'] : NULL;
        $date = !empty($_POST['date']) ? $_POST['date'] : NULL;
        $photo = !empty($_FILES['photo']) ? $_FILES['photo'] : NULL;        

        $msg['msg'] = [];
        if($name == null || $email == null || $date == null)
        {            
            $msg['msg']['field'] = Msg::EMPTY_FIELD;            
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
            $msg['msg']['email'] = Msg::EMAIL_FORMAT;
        }
        //---- Enviar errores
        if(!empty($msg['msg']))
        {            
            echo json_encode($msg['msg']);
        }
        else{            
            //---- Almacenar foto 
            $namePhoto = $_SESSION['auth']->photo;
            
            if(!is_null($photo)){
                $mimetype   = $photo['type'];                

                if($mimetype == "image/jpg" || $mimetype == 'image/jpeg' || $mimetype == 'image/png' || $mimetype == 'image/gif')
                {                                       
                    if(!is_dir('uploads/user')){
                        mkdir('uploads/user', 0777, true);
                    }
                    $namePhoto  = date("d-m-Y").'_'.$name.'_'.$photo['name'];
                    move_uploaded_file($photo['tmp_name'], 'uploads/user/'.$namePhoto);
                    
                    //Eliminar foto antigua                                  
                    $gestor = opendir('uploads/user/');
                    if($gestor){
                        while(($ficheros = readdir($gestor)) !== false){
                            if($ficheros == $_SESSION['auth']->photo){
                                unlink('uploads/user/'.$ficheros);
                            }
                        }
                    }
                }                
            }

            //---- Almacenar datos en BD
            $user = new User();
            
            //validar correo y nombre de usuario existente (true = y que sea diferente al id del usuario logeado)
            if($user->emailExist($email, true)){
                $msg['msg']['email_exist'] = Msg::EMAIL_EXIST;                
            }
            if($user->nameExist($name, true)){
                $msg['msg']['name_exist'] = Msg::NAME_EXIST;
            }
            if(empty($msg['msg'])){
                $user->setName($name);
                $user->setBirth_date($date);
                $user->setPhoto($namePhoto);
                $user->setEmail($email);
                $save = $user->edit();

                $msg['msg']['success'] = Msg::MSG_SUCCESS;
            }
            echo json_encode($msg['msg']);            
        }
    }

    public function editPassProfile()
    {
        $this->headJson();

        $pass = !empty($_POST['password']) ? $_POST['password'] : NULL;

        $msg['msg'] = [];
        if($pass == null){
            $msg['msg']['field'] = Msg::ALL_FIELDS;
        }
        if(strlen($pass) > 8 || strlen($pass) < 4){
            $msg['msg']['pass'] = Msg::PASS_LENGTH;
        }
        if(empty($msg['msg'])){

            $user = new User();
            $user->setPassword($pass);

            if($user->editPassword()){
                $msg['msg']['success'] = Msg::MSG_SUCCESS;
            }else{
                $msg['msg']['error'] = Msg::FAILED_OPERATION;
            }
        }
        echo json_encode($msg['msg']);
    }

    public function showFormAdmin()
    {
        if(!isset($_SESSION['auth'])){
            return $this->redirect("/");
        }else{
            if($_SESSION['auth']->id_rol == 1){
                return $this->view('create_admin');
            }else{
                return $this->redirect("/");
            }
             
        }
    }

    public function createAdmin()
    {
        $this->headJson();
        $this->validateToken($_POST['token_']);

        $name   = !empty($_POST['name'])     ? $_POST['name']       : NULL;
        $email  = !empty($_POST['email'])    ? $_POST['email']      : NULL;
        $date   = !empty($_POST['date'])     ? $_POST['date']       : NULL;      
        $pass   = !empty($_POST['password']) ? $_POST['password']   : NULL;
        //---- Almacenar errores
        $msg['msg'] = [];
        if($name == null || $email == null || $date == null || $pass == null)
        {            
            $msg['msg']['field'] = Msg::EMPTY_FIELD;            
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
            $msg['msg']['email'] = Msg::EMAIL_FORMAT;
        }
        if(strlen($pass) > 8 || strlen($pass) < 4){
            $msg['msg']['pass'] = Msg::PASS_LENGTH;
        }
        //instanciamos un obj user
        $user = new User();
        //validamos name y email existentes
        if($user->emailExist($email, false)){
            $msg['msg']['email_exist'] = Msg::EMAIL_EXIST;                
        }
        if($user->nameExist($name, false)){
            $msg['msg']['name_exist'] = Msg::NAME_EXIST;
        }
        if(empty($msg['msg'])){
            $user->setName($name);
            $user->setBirth_date($date);
            $user->setEmail($email);
            $user->setPassword($pass);
            $save = $user->insertAdmin();

            $msg['msg']['success'] = Msg::MSG_SUCCESS;
            }
        echo json_encode($msg['msg']); 
    }
    
    public function delete($user)
    {
        if(isset($_SESSION['auth'])){

            $userDelete = new User();
            $photo = $userDelete->getPhotoUser($user);

            if($_SESSION['auth']->id_user == $user){
                
                $result = $userDelete->delUser($_SESSION['auth']->id_user);
                if($result){
                    //Eliminar foto                            
                    $this->deletePhoto($_SESSION['auth']->photo);
                    //eliminar sesion si es el mismo usuario
                    unset($_SESSION['auth']);             
                    return $this->redirect('/');                    
                }                
            }
            elseif($_SESSION['auth']->id_rol = 3 || $_SESSION['auth']->id_rol = 1){

                $result = $userDelete->delUser($user);
                $this->deletePhoto($photo->photo);

                return $this->redirect('/usuarios');

            }else{
                return $this->redirect('/');
            }
        }
        else{
            return $this->redirect('/');
        }
    }

    public function deletePhoto($photo){
        $gestor = opendir('uploads/user/');
        if($gestor){
            while(($ficheros = readdir($gestor)) !== false){
                if($ficheros == $photo){
                    unlink('uploads/user/'.$ficheros);
                }
            }
        }
    }
}