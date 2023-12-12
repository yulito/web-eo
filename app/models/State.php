<?php

namespace App\Models;

class State extends Model
{
    protected $table = 'state';

    public function getSt(){
        $sql = "SELECT * FROM state WHERE id_state != 3";
        $st = $this->connection->query($sql);
        return $st;
    }
}