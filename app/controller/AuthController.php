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

    /* Redirecciona a AuthView llamando vista de formulario de logueo */
    function login(){
        $this->view->showLoginForm();
    }

    /* Redirecciona a AuthView llamando vista de formulario de registro de usuario */
    function registerForm(){
        $this->view->showRegisterForm();
    }

    /*
    Metodo de autenticacion de usuario a traves de email y password,
    si el usuario existe carga la sesion con los datos del user y redirige a home.
    En caso de error muestra pantalla de error con mensaje y posible accion. */
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
            $this->authError("No es posible loguearse con datos vacíos, asegurese de completar todos los campos.");
        }
    }

    /*
    Metodo de registro de nuevo usuario a traves de email y password hasheada,
    se crea el nuevo user, se carga la sesion con los datos del user y redirige a home.
    En caso de error muestra pantalla de error con mensaje y posible accion. */
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
            $this->authError("No es posible registrar un usuario con datos vacíos, asegurese de completar todos los campos.");
        }
    }

    /*
    Metodo de restriccion de acceso a contenido
    de usuario en sesion que no sea de tipo ADMIN */
    function checkAdmin(){
        if(!$this->isAdmin()){
            $this->authError("No tiene permisos para acceder a esta seccion.");
        }
    }

    /*
    Metodo de cierre y eliminacion de
    datos de usuario en sesion y redireccion a home */
    function logout(){
        session_start();
        session_destroy();
        header('Location: ' . BASE_URL . '/');

    }

    /*
    Metodo de carga de datos de email, ID y tipo
    de usuario en sesion */
    function chargeSession($user){
        $_SESSION['user_id'] = $user->id;
        $_SESSION['email'] = $user->email;
        $_SESSION['admin'] = $user->admin;
    }

    /*
    Metodo que chequea si el usuario
    existente en sesion es de tipo ADMIN */
    function isAdmin(){
        return isset($_SESSION['admin']) && $_SESSION['admin'] == true;
    }

    /*
    Metodo que redirige a vista
    de pantalla de error y muestra mensaje
    enviado por parametro */
    function authError($error){
        $this->view->showError($error);
    }
}