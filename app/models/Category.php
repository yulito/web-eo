<?php

namespace App\Models;

class Category extends Model
{
    protected $table = 'category';

    public function getCat(){
        $sql = "SELECT * FROM category";
        $cat = $this->connection->query($sql);
        return $cat;
    }
    public function getOne($id){
        $sql = "SELECT * FROM category WHERE id_cat = '$id'";
        $cat = $this->connection->query($sql);
        return $cat->fetch_assoc();
    }
}