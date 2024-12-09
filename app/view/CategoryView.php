<?php
require_once 'View.php';

class CategoryView extends View{

    /*
    Metodo que asigna tipo de usuario comun o admin segun corresponda y despliegua vista
    de todas las categorias recibidos por parametro en formato lista. La vista para usuarios
    ADMIN agrega columna con botones de edicion y eliminacion, y boton de registro de nueva categoria. */
    function showAllCategories($categories, $admin){
        $this->smarty->assign('categories', $categories);
        $this->smarty->assign('admin', $admin);
        $this->smarty->display('categories/categoryList.tpl');
    }

    /*
    Metodo muestra formulario de creacion/edicion de categorias. El metodo recibe categoria
    por parametro. En caso de recibir una categoria cargada con datos, el formulario se
    carga con los datos de la misma, en cualquier otro caso el formulario se muestra vacio. */
    function showCategoryForm($category = null){
        $this->smarty->assign('category', $category);
        $this->smarty->display('categories/categoryForm.tpl');
    }

    /*
    Metodo que recibe mensaje de error en formato string y despliega
    pantalla de error con mensaje de error de categoria. */
    function showErrorCategory(String $error){
        $this->smarty->assign('error', $error);
        $this->smarty->display('error/error.tpl');
    }
}