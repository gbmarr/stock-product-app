<?php
require_once './libs/Smarty.class.php';
require_once './BASE_URL.php';

class View{
    protected $smarty;

    function __construct(){
        $this->smarty = new Smarty();

        $user = isset($_SESSION['email']) ? true : false;
        $admin = isset($_SESSION['admin']) ? true : false;

        $this->smarty->assign('user', $user);
        $this->smarty->assign('admin', $admin);

        $this->smarty->setTemplateDir('templates/');
    }
}