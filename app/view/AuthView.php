<?php
require_once 'View.php';

class AuthView extends View{

    function showLoginForm($error = null){
        $this->smarty->assign('Error', $error);
        $this->smarty->display('auth/loginForm.tpl');
    }
}