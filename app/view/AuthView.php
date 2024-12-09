<?php
require_once 'View.php';

class AuthView extends View{

    /*
    Metodo que despliega vista de formulario de login de usuario. */
    function showLoginForm($error = null){
        $this->smarty->assign('Error', $error);
        $this->smarty->display('auth/loginForm.tpl');
    }

    /*
    Metodo que despliega vista de formulario de registro de nuevo usuario. */
    function showRegisterForm($error = null){
        $this->smarty->assign('Error', $error);
        $this->smarty->display('auth/registerForm.tpl');
    }

    /*
    Metodo que recibe mensaje de error en formato string y despliega
    pantalla de error con mensaje de error de login/register. */
    function showError(String $error){
        $this->smarty->assign('error', $error);
        $this->smarty->display("error/error.tpl");
    }
}