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
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $email = $_POST['email'];
            $pass = $_POST['password'];
            if(!empty($email) && !empty($pass)){
                $user = $this->user->validateUser($email, $pass);
                // $user = $this->user->getUserByEmail($email);
                if($user){
                    $this->chargeSession($user);
                    //$_SESSION['user_id'] = $user->id;
                    //$_SESSION['user'] = $user;
                    //$_SESSION['email'] = $user->email;
                    //$_SESSION['admin'] = $user->admin;
                    header('Location: ' . BASE_URL . '/home');
                }else{
                    $this->view->showRegisterForm('Invalid email or password');
                }
            }else{
                $this->view->showLoginForm('Data empty');
            }
        }else{
            $this->view->showLoginForm('No POST method');
        }
    }

    function register(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $email = $_POST['email'];
            $pass = $_POST['password'];
            if(!empty($email) && !empty($pass)){
                $this->user->addUser($email, $pass);

                $newUser = $this->user->getUserByEmail($email);
                $this->chargeSession($newUser);
                header('Location: ' . BASE_URL . '/home');
            }else{
                $this->view->showRegisterForm('Data empty');
            }
        }else{
            $this->view->showRegisterForm('No POST method');
        }
    }

    function checkAdmin(){
        if(!isset($_SESSION['user']) || !($_SESSION['user']->admin)){
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
        $_SESSION['user'] = $user;
        $_SESSION['email'] = $user->email;
        $_SESSION['admin'] = $user->admin;
    }
}