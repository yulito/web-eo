<?php

namespace App\Models;

use Exception;

class Publication extends Model
{
    protected $table = 'publication';

    private $title;
    private $publication;
    private $idstate;
    private $iduser;
    private $idcat;

    function setTitle($title){
        $this->title = $this->connection->real_escape_string($title);
    }
    function setPublication($publication){
        $this->publication = $this->connection->real_escape_string($publication);
    }
    function setIdstate($idstate){
        $this->idstate = $idstate;
    }
    function setIdcat($idcat){
        $this->idcat = $idcat;
    }
    function getTitle(){
        return $this->title;
    }
    function getPublication(){
        return $this->publication;
    }
    function getIdstate(){
        return $this->idstate;
    }
    function getIdcat(){
        return $this->idcat;
    }
    //crud
    public function createPublication(){
        $sql = "INSERT INTO publication (title, publication, id_state, id_user, id_cat) 
                VALUES ('{$this->getTitle()}','{$this->getPublication()}','{$this->getIdstate()}','{$_SESSION['auth']->id_user}','{$this->getIdcat()}')";

        $result = $this->connection->query($sql);
        return $result ? true : false;
    }
    public function getAll( $idSt, $cat, $name, $lmt){
        $sql = "SELECT p.title, p.publication, p.updated_at ,
                u.name, u.photo, s.state, c.cat, 
                id_publication, id_cat, id_user, id_state
                FROM publication p JOIN users u USING(id_user)
                         JOIN state s USING(id_state)
                         JOIN category c USING(id_cat) ";
        if($idSt){
            $sql .= " WHERE id_state = '$idSt' "; //aca no puede traer un false por el where
        }else{
            $sql .= " WHERE id_state != 3 ";
        }
        if($cat){
            $sql .= " AND id_cat = '$cat' ";
        }
        if($name){
            $sql .= " AND name = '$name' ";
        }
        $sql .= " ORDER BY updated_at DESC ";
        if($lmt){
            $sql .= " LIMIT $lmt ";
        }

        $pbls = $this->connection->query($sql);
        if($pbls->num_rows > 0){
            while($data = $pbls->fetch_assoc()){
                $publications[] = $data;
            }
            return $publications;
        }else{
            return false;
        }      
    }
    public function getOne($id, $idSt){
        $sql = "SELECT p.title, p.publication, p.updated_at ,
                u.name, u.photo, s.state, c.cat, 
                id_publication, id_cat, id_user, id_state
                FROM publication p JOIN users u USING(id_user)
                        JOIN state s USING(id_state)
                        JOIN category c USING(id_cat) 
                        WHERE id_publication = '$id'";
        if($idSt){
            $sql .= " AND id_state = '$idSt'";
        }
        else{
            $sql .= " AND id_state != 3";
        }
        $pbl = $this->connection->query($sql);
        $result = $pbl->fetch_object();
        return $result;
    }
    public function search( $cat = null, $name = null){
        $sql = "SELECT * FROM publication JOIN users USING(id_user)
                         JOIN state USING(id_state)
                         JOIN category USING(id_cat)
                         WHERE id_state = 2";
        if($cat){
            $sql .= " OR id_cat LIKE %'$cat'%";
        }
        if($name){
            $sql .= " OR name LIKE %'$name'%";
        }
       
    }
    public function changeStatus($id, $state){
        $sql = "UPDATE publication SET
                id_state = '$state' WHERE id_publication = '$id'";
        $result = $this->connection->query($sql);
        return $result ? true : false;
    }
    public function editPublication($id){
        $sql = "UPDATE publication SET
                title = '{$this->getTitle()}',
                publication = '{$this->getPublication()}',
                id_state = '{$this->getIdstate()}',
                id_cat = '{$this->getIdcat()}',
                updated_at = NOW()
                WHERE id_publication = '$id'";
        $result = $this->connection->query($sql);
        return $result ? true : false;
    }
    public function deleteJoke($id){
        //usaremos una transaccion debido a la ejecucion de varias tablas relacionadas
        $sql1 = "DELETE FROM likes WHERE id_publication = '$id'";
        $sql2 = "DELETE FROM favourite WHERE id_publication = '$id'";
        $sql3 = "DELETE FROM publication WHERE id_publication = '$id'";

        try{

            $this->connection->begin_transaction();
            
            $this->connection->query($sql1);            
            $this->connection->query($sql2);
            $this->connection->query($sql3);

            $result = $this->connection->commit();

        }catch(Exception $e){
            $result = $this->connection->rollback();
        }

        
        return $result ? true : false;
    }
}