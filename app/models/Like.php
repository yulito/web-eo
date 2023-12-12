<?php

namespace App\Models;

class Like extends Model
{
    protected $table = 'likes';

    public function getLikes($id){
        $sql = "SELECT count(*) sum_like
                FROM likes 
                WHERE id_publication ='$id'";
        $likes = $this->connection->query($sql);
        return $likes;
    }

    public function operator($id){
        
        $result = $this->verifyUser($id);

        if(!$result){
            $sql = "INSERT INTO likes (id_user, id_publication) VALUES('{$_SESSION['auth']->id_user}', '{$id}')";
        }else{
            $sql = "DELETE FROM likes WHERE id_user = '{$_SESSION['auth']->id_user}' AND id_publication = '$id'";
        }
        $result = $this->connection->query($sql);
        return $result ? true : false;
    }

    public function verifyUser($id){
        $sql = "SELECT * FROM likes WHERE id_publication = '$id' AND id_user = '{$_SESSION['auth']->id_user}'";
        $result = $this->connection->query($sql);
        return $result->fetch_object() ? true : false;
    }

}