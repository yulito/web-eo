<?php

namespace App\Controllers;

use App\Helpers\Msg;
use App\Models\Like;

class LikeController extends Controller{

    public function store(){
        header("Access-Control-Allow-Origin: *");
        $this->headJson();
        $data = json_decode(file_get_contents('php://input'), true);

        $obj = new Like();
        if($data['idPub']){
            $result = $obj->operator($data['idPub']);
            $result ? $msg['msg']['success'] = Msg::MSG_SUCCESS :  $msg['msg']['error'] = Msg::FAILED_OPERATION;
        }                         
        
        echo json_encode($msg['msg']);        
    }
}