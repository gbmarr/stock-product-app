<?php
require_once 'Model.php';

class UserModel extends Model{

    /*
    Metodo que obtiene registro de la tabla users mediante comparacion de
    dato email recibido por parametro con campo de email y en caso de coincidencia lo retorna. */
    function getUserByEmail($email){
        $query = "SELECT `email`, `pass`, `admin` FROM `users` WHERE `email` = ?";
        $user = $this->executeQuery($query, [$email]);
        return $user->fetch(PDO::FETCH_OBJ);
    }

    /*
    Metodo que realiza un INSERT en tabla users. El mismo recibe email y pass
    del nuevo usuario y lo almacena en la DB como nuevo registro de la tabla. */
    function addUser($email, $pass){
        $pass = password_hash($pass, PASSWORD_BCRYPT);
        $query = "INSERT INTO `users` (`email`, `pass`) VALUES (?, ?)";
        $this->executeQuery($query, [$email, $pass]);
    }

    /*
    Metodo de validacion de usuario, recibiendo email y pass del usuario a validar.
    Se consulta la existencia y obtiene el usuario a partir del email y en caso de ser
    positivo se verifica la coincidencia de passwords entre la del user almacenado en DB
    y la recibida por parametro. De ser positiva la respuesta, se retorna el user, en caso
    contrario se retorna NULL. */
    public function validateUser($email, $pass){
        $user = $this->getUserByEmail($email);
        if($user && password_verify($pass, $user->pass)){
            return $user;
        }
        return null;
    }
}