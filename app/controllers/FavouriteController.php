<?php

namespace App\Controllers;

use App\Helpers\Msg;
use App\Models\Favourite;

class FavouriteController extends Controller{

    public function store(){
        header("Access-Control-Allow-Origin: *");
        $this->headJson();
        $data = json_decode(file_get_contents('php://input'), true);

        $obj = new Favourite();
        if($data['idPub']){
            $result = $obj->action($data['idPub']);
            $result ? $msg['msg']['success'] = Msg::MSG_SUCCESS :  $msg['msg']['error'] = Msg::FAILED_OPERATION;
        }                         
        
        echo json_encode($msg['msg']);
    }

    public function show(){        

        if(isset($_SESSION['auth']) && $_SESSION['auth']->id_rol == 4){
            $fav = new Favourite();
            $result = $fav->getAll();
            if($result){
                return $this->view('favorites', ['obj'=>$result]);
            }else{
                return $this->view('favorites', ['msg'=>'No has agregado a favoritos']);
            }  
        }else{
            return $this->redirect('/');
        }  
    }

}