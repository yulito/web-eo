<?php

namespace App\Models;

class Favourite extends Model{

    protected $table = 'favourite';

    public function action($id){
        $result = $this->verifyFav($id);

        if(!$result){
            $sql = "INSERT INTO favourite (id_user, id_publication) VALUES('{$_SESSION['auth']->id_user}', '{$id}')";
        }else{
            $sql = "DELETE FROM favourite WHERE id_user = '{$_SESSION['auth']->id_user}' AND id_publication = '$id'";
        }
        $result = $this->connection->query($sql);
        return $result ? true : false;
    }

    public function verifyFav($id){
        $sql = "SELECT * FROM favourite WHERE id_publication = '$id' AND id_user = '{$_SESSION['auth']->id_user}'";
        $result = $this->connection->query($sql);
        return $result->fetch_object() ? true : false;
    }

    public function getAll(){
        $sql = "SELECT 
                f.*, 
                p.title,
                p.id_user,
                p.updated_at,
                u.name
                FROM favourite f LEFT OUTER JOIN publication p USING(id_publication)					
                                LEFT OUTER JOIN users u ON(p.id_user = u.id_user)
                                WHERE f.id_user = '{$_SESSION['auth']->id_user}'";
        $result = $this->connection->query($sql);
        if($result->num_rows > 0){
            while($data = $result->fetch_assoc()){
                $publications[] = $data;
            }
            return $publications;
        }else{
            return false;
        }  
    }
}