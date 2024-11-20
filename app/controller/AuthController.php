<?php
require_once 'app/view/AuthView.php';
require_once 'app/model/UserModel.php';

class AuthController{
    private $view;
    private $user;

    function __construct(){
        $this->view = new AuthView();
        $this->user = new UserModel();
    }

    function login(){
        $this->view->showLoginForm();
    }

    function registerForm(){
        $this->view->showRegisterForm();
    }

    function authenticate(){
        if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['email']) && !empty($_POST['password'])){
            $email = $_POST['email'];
            $pass = $_POST['password'];
            
            $user = $this->user->validateUser($email, $pass);
            if($user){
                $this->chargeSession($user);
                header('Location: ' . BASE_URL . '/home');
            }else{
                $this->authError("Verifique sus datos e intentelo nuevamente. De persistir el error, pruebe registrandose.");
            }
        }else{
            $this->view->showLoginForm();
        }
    }

    function register(){
        if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['email']) && !empty($_POST['password'])){
            $email = $_POST['email'];
            $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $userExist = $this->user->getUserByEmail($email);
            if(!isset($userExist)){
                $this->user->addUser($email, $pass);
                $newUser = $this->user->getUserByEmail($email);

                $this->chargeSession($newUser);
                header('Location: ' . BASE_URL . '/');
            }else{
                $this->authError("El email utilizado ya posee una cuenta, intente con un email diferente.");
            }
        }else{
            $this->view->showRegisterForm('Data empty');
        }
    }

    function checkAdmin(){
        if(!isset($_SESSION['admin']) || $_SESSION['admin'] == false){
            header('Location: ' . BASE_URL . '/');
        }
    }

    function logout(){
        session_start();
        session_destroy();
        header('Location: ' . BASE_URL . '/');

    }

    function chargeSession(Object $user){
        $_SESSION['user_id'] = $user->id;
        $_SESSION['email'] = $user->email;
        $_SESSION['admin'] = $user->admin;
    }

    function isAdmin(){
        return isset($_SESSION['admin']) && $_SESSION['admin'] == true;
    }

    function authError(String $error){
        $this->view->showError($error);
    }
}