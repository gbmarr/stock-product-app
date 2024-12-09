<?php
require_once 'View.php';

class ProductView extends View{

    /*
    Metodo de despliegue de vista de todos los productos
    recibidos por parametro en formato cards. */
    function showAllProducts($products){
        $this->smarty->assign('products', $products);
        $this->smarty->display('products/productCards.tpl');
    }

    /*
    Metodo que asigna tipo de usuario comun o admin segun corresponda y despliegua vista
    de todos los productos recibidos por parametro en formato lista. La vista para usuarios
    ADMIN agrega columna con botones de edicion y eliminacion, y boton de registro de nuevo producto. */
    function showAllProductsList($products, $categories, $filter = null, $admin){
        $this->smarty->assign('products', $products);
        $this->smarty->assign('categories', $categories);
        $this->smarty->assign('filter', $filter);
        $this->smarty->assign('admin', $admin);
        $this->smarty->display('products/productList.tpl');
    }

    /*
    Metodo que recibe un producto por parametro y
    despliega vista que muestra al mismo en pantalla de detalle. */
    function showProductDetail($product){
        $this->smarty->assign('product', $product);
        $this->smarty->display('products/productDetail.tpl');
    }

    /*
    Metodo muestra formulario de creacion/edicion de productos. El metodo recibe producto
    y lista de categorias por parametro. En caso de recibir un producto cargado con datos,
    el formulario se carga con los datos del mismo, en cualquier otro caso el formulario
    se muestra vacio. La lista de categorias se recibe para setear el campo select del formulario. */
    function showProductForm($product = null, $categories = null){
        $this->smarty->assign('product', $product ? $product : null);
        $this->smarty->assign('categories', $categories);
        $this->smarty->display('products/productForm.tpl');
    }

    /*
    Metodo que recibe mensaje de error en formato string y despliega
    pantalla de error con mensaje de error de producto. */
    function showErrorProduct(String $error){
        $this->smarty->assign('error', $error);
        $this->smarty->display('error/error.tpl');
    }
}