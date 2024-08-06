<?php
require_once 'Model.php';

class UserModel extends Model{

    function getUserByEmail($email){
        $query = "SELECT `email`, `pass`, `admin` FROM `users` WHERE `email` = ?";
        $user = $this->executeQuery($query, [$email]);
        return $user->fetch(PDO::FETCH_OBJ);
    }

    function addUser($email, $pass){}

    public function validateUser($email, $pass){}
}