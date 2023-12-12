<?php

namespace App\Models;

use Exception;

class User extends Model
{
    protected $table = 'users';
    
    private $name;
    private $birth_date;
    private $photo;
    private $email;
    private $password;

    
    function setName($name){
        $this->name = $this->connection->real_escape_string($name);
    }
    function setBirth_date($birth_date){
        $this->birth_date = $this->connection->real_escape_string($birth_date);
    }
    function setPhoto($photo){
        $this->photo = $this->connection->real_escape_string($photo);
    }
    function setEmail($email){
        $this->email = $this->connection->real_escape_string($email);
    }
    function setPassword($password){
        $this->password = password_hash($this->connection->real_escape_string($password), PASSWORD_BCRYPT, ['cost' => 4]);
    }

    function getName(){
        return $this->name;
    }
    function getBirth(){
        return $this->birth_date;
    }
    function getPhoto(){
        return $this->photo;
    }
    function getEmail(){
        return $this->email;
    }
    function getPass(){
        return $this->password;
    }

    public function getAll($rol)
    {
        $sql = "SELECT * FROM users ";
        if($rol){
            $sql .= "WHERE id_rol = '$rol'";
        }else{
            $sql .= "WHERE id_rol != 1";
        }
        $result = $this->connection->query($sql);
        if($result->num_rows > 0){
            while($data = $result->fetch_assoc()){
                $users[] = $data;
            }
            return $users;
        }else{
            return false;
        }      
    }

    public function getOne($id)
    {
        $sql = "SELECT * FROM users where id_user = '{$id}'";
        $user = $this->connection->query($sql);
        $result = $user->fetch_object();
        if($result){
            return $result;
        }
        else{
            return false;
        }
    }

    public function getUserByName($name)
    {
        $sql = "SELECT id_user, name, TIMESTAMPDIFF(YEAR,birth_date,CURDATE()) AS age ,photo, updated_at FROM users WHERE name = '$name'";
        $result = $this->connection->query($sql);
        return $result ?  $result->fetch_object() : false;
    }

    public function insert(){ 
        //generamos el insert para la consulta
        $sql = "INSERT INTO {$this->table} (name, birth_date, photo, email, password, id_rol) 
                VALUES ('{$this->getName()}','{$this->getBirth()}','{$this->getPhoto()}','{$this->getEmail()}','{$this->getPass()}', 4)";

        $save = $this->connection->query($sql); 
    }

    public function insertAdmin()
    {
        $sql = "INSERT INTO {$this->table} (name, birth_date, email, password, id_rol) 
                VALUES ('{$this->getName()}','{$this->getBirth()}','{$this->getEmail()}','{$this->getPass()}', 3)";

        $save = $this->connection->query($sql);
        return $save ? true : false;
    }

    public function edit()
    {
        $sql = "UPDATE users SET 
                    name = '{$this->getName()}',
                    birth_date = '{$this->getBirth()}',
                    photo = '{$this->getPhoto()}',
                    email = '{$this->getEmail()}',
                    updated_at = NOW()
                    WHERE id_user = '{$_SESSION['auth']->id_user}'";
        $save = $this->connection->query($sql);
        $result = false;
        if($save)
        {   
            $user = $this->getOne($_SESSION['auth']->id_user);
            $_SESSION['auth'] = $user;
            $result = true;
        }
        return $result;
    }

    public function enter($pass){

        $email = $this->getEmail();
		
		// Comprobar si existe el usuario
		$sql = "SELECT * FROM users WHERE email = '$email'";
		$login = $this->connection->query($sql);		

        $result = '';
		if($login && $login->num_rows == 1){
			$user = $login->fetch_object();
			$verify = password_verify($pass, $user->password); 

			if($verify){
				$result = $user;
			}
		}
        return $result;
    }

    public function emailVerifyToken(){
        $sql = "SELECT * from users WHERE email = '{$this->getEmail()}'";
        $person = $this->connection->query($sql);		

        $result = false;
		if($person && $person->num_rows == 1){

            $token = uniqid();
            $sql = "UPDATE users SET token = '{$token}' WHERE email = '{$this->getEmail()}'";
            $this->connection->query($sql);

			$result = $token;
        }
        return $result;
    }

    public function refreshPassword($token){

        $sql = "SELECT id_user FROM users WHERE token = '{$token}'";
        $values = $this->connection->query($sql);

        $result = false;
        if($values){
            $id = $values->fetch_object();
            $sql = "UPDATE users SET token = null,
                    password = '{$this->getPass()}'
                    WHERE id_user = '$id->id_user'";
            $this->connection->query($sql);
            $result = true;
        }

        return $result;
    }

    public function editPassword(){
        $sql = "UPDATE users SET
                    password = '{$this->getPass()}'
                    WHERE id_user = '{$_SESSION['auth']->id_user}'";
        $result = $this->connection->query($sql);
        return $result ? true : false;
    }

    public function emailExist($email, $bool){
        $sql = "SELECT * FROM users WHERE email = '{$email}'";
        if($bool)
        {
            $sql .= " AND id_user != '{$_SESSION['auth']->id_user}'";
        }
        $result = $this->connection->query($sql);        
        return $result->num_rows == 1 ? true : false;        
    }

    public function nameExist($name, $bool){
        $sql = "SELECT * FROM users WHERE name = '{$name}'";
        if($bool)
        {
            $sql .= " AND id_user != '{$_SESSION['auth']->id_user}'";
        }
        $result = $this->connection->query($sql);        
        return $result->num_rows == 1 ? true : false;
    }

    public function delUser($id){

        //eliminar los likes y fav que ha hecho el usuario
        $sql1 = "DELETE FROM likes WHERE id_user = '$id'";
        $sql2 = "DELETE FROM favourite WHERE id_user = '$id'";        

        //eliminar usuario y cuenta        
        $sql7 = "DELETE FROM users WHERE id_user = '$id'";

        try{

            $this->connection->begin_transaction();
            
            $this->connection->query($sql1);            
            $this->connection->query($sql2);

            //obtener id_publication de las publicaciones del ususario a eliminar
            $sql3 = "SELECT id_publication FROM publication WHERE id_user = '$id'";
            $idPub = $this->connection->query($sql3);

            if($idPub){
                //eliminar los likes y fav de usuarios a la publicacion del usuario a eliminar (usar ciclo)
                while($id_pub = $idPub->fetch_object()){
                    
                    $sql4 = "DELETE FROM likes WHERE id_publication = '$id_pub->id_publication'";
                    $sql5 = "DELETE FROM favourite WHERE id_publication = '$id_pub->id_publication'";
                    $sql6 = "DELETE FROM publication WHERE id_publication = '$id_pub->id_publication'";

                    $this->connection->query($sql4);
                    $this->connection->query($sql5);
                    $this->connection->query($sql6); 
                }
            }
                   
            $this->connection->query($sql7);

            $result = $this->connection->commit();

        }catch(Exception $e){
            $result = $this->connection->rollback();
        }

        
        return $result ? true : false;
    }

    public function getPhotoUser($user){
        $sql = "SELECT photo FROM users WHERE id_user = '$user'";
        $result = $this->connection->query($sql);
        return $result ? $result->fetch_object() : false;
    }
}