<?php

namespace App\Controllers;

use App\Controllers\UserController as ControllersUserController;
use App\Helpers\Msg;
use App\Models\Category;
use App\Models\Publication;
use App\Models\User;

class PublicationController extends Controller{

    public function show()
    {
        if($_SESSION['auth']->id_rol == 4){
            return $this->view('addjoke');
        }else{
            return $this->redirect('/');
        }
    }
    
    public function store()
    {
        $this->headJson();
        $this->validateToken($_POST['token_']);

        $title = !empty($_POST['title']) ? $_POST['title'] : NULL;
        $publication = !empty($_POST['publication']) ? $_POST['publication'] : NULL;
        $state = isset($_POST['state']) ? (int)$_POST['state'] : NULL; 
        $cat = isset($_POST['cat']) ? (int)$_POST['cat'] : NULL;     

        $msg['msg'] = [];
        if($title == null || $publication == null || $state == null || $cat == null){
            $msg['msg']['field'] = Msg::EMPTY_FIELD;
        }
        else{
            $joke = new Publication();
            $joke->setTitle($title);
            $joke->setPublication($publication);
            $joke->setIdstate($state);
            $joke->setIdcat($cat);
            $save = $joke->createPublication();
            if($save){
                $msg['msg']['success'] = Msg::MSG_SUCCESS;
            }else{
                $msg['msg']['error'] = Msg::FAILED_OPERATION;
            }
        }
        echo json_encode($msg['msg']); 
    }

    public function list(){

        $this->headJson();

        $pub = new Publication();
        $objs = $pub->getAll(2, false, false, 6);
        if($objs){
            echo json_encode($objs);
        }else{
            echo json_encode(['empty'=>'No hay nada para mostrar']);
        }           
    }

    public function showJoke($id, $name){ //los parametros del Route get se obtienen de esta manera

        $pub = new Publication();

        if(isset($_SESSION['auth'])){
            if($_SESSION['auth']->name == $name){
                $obj = $pub->getOne($id, false);
            }else{
                $obj = $pub->getOne($id, 2);
            }
        }else{
            $obj = $pub->getOne($id, 2);
        }   
        if(!$obj){
            return $this->redirect("/");
        }
        return $this->view('joke',['obj'=>$obj]);
    }

    public function showDiscarded($name){        

        if(isset($_SESSION['auth']) && $_SESSION['auth']->name == $name){
            $pub = new Publication();
            $objs = $pub->getAll(3, false, $name, false);
            if($objs){
                $obj = ['obj'=>$objs];
            }else{
                $obj = ['empty'=>'no hay ningun chiste descartado'];
            }
            return $this->view('discarded', $obj);
        }else{
            return $this->redirect('/');
        }
    }

    public function discarded($id,$name){
        $pub = new Publication();
        $obj = $pub->changeStatus($id, 3);
        if($obj){
            return $this->redirect("/perfil/{$name}");
        }
    }

    public function restore($id){
        $obj = new Publication();
        $obj->changeStatus($id, 1);
        if($obj){
            return $this->redirect("/desechados/{$_SESSION['auth']->name}");
        }
    }
    
    public function delete($id){
        $obj = new Publication();
        $obj->deleteJoke($id);
        if($obj){
            return $this->redirect("/desechados/{$_SESSION['auth']->name}"); 
        }
    }

    public function showUpdate($id, $name){
        if(isset($_SESSION['auth'])){
            if($_SESSION['auth']->name == $name){
                $obj = new Publication();
                $obj = $obj->getOne($id, false);
                return $this->view("editJoke",['obj'=>$obj]);
            }else{
                return $this->redirect("/");                
            }
        }else{
            return $this->redirect("/");
        }
    }

    public function update(){
        $this->headJson();
        $this->validateToken($_POST['token_']);

        $id             =   !empty($_POST['idPub']) ? $_POST['idPub'] : NULL;
        $title          =   !empty($_POST['title']) ? $_POST['title'] : NULL;
        $publication    =   !empty($_POST['publication']) ? $_POST['publication'] : NULL;
        $state          =   !empty($_POST['state']) ? (int)$_POST['state'] : NULL;
        $cat            =   !empty($_POST['cat']) ? (int)$_POST['cat'] : NULL;

        $msg['msg'] = [];
        if(is_null($id) || is_null($title) || is_null($publication) || is_null($state) || is_null($cat)){
            $msg['msg']['field'] = Msg::ALL_FIELDS;
        }
        else{
            $joke = new Publication();
            $joke->setTitle($title);
            $joke->setPublication($publication);
            $joke->setIdstate($state);
            $joke->setIdcat($cat);
            $save = $joke->editPublication($id);
            if($save){
                $msg['msg']['success'] = Msg::MSG_SUCCESS;
            }else{
                $msg['msg']['error'] = Msg::FAILED_OPERATION;
            }
        }
        echo json_encode($msg['msg']); 
    }

    public function showCategory($id){
        $pub = new Publication();
        $cat = new Category();

        $cat = $cat->getOne($id);
        $pub = $pub->getAll(2, $id, false, false);

        if($cat){
            return $this->view('category',['catObj'=>$cat, 'allObj'=> $pub]);
        }else{
            return $this->view('category',['msg'=> Msg::ERROR_404]);
        }       
    }
    
}
