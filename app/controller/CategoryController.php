<?php
require_once 'app/model/CategoryModel.php';
require_once 'app/view/CategoryView.php';
require_once 'app/controller/AuthController.php';

class CategoryController extends AuthController{
    private $categoryModel;
    private $categoryView;

    function __construct(){
        $this->categoryModel = new CategoryModel();
        $this->categoryView = new CategoryView();
    }

    /*
    Metodo que obtiene el total de categorias existentes
    en DB, y luego envia a vista de categorias para listar. */
    function viewAllCategories(){
        $categories = $this->categoryModel->getAllCategories();
        $this->categoryView->showAllCategories($categories, $this->isAdmin());
    }

    /*
    Metodo que redirecciona a vista de formulario para
    creacion de nueva categoria. */
    function createCategory(){
        $this->checkAdmin();
        $this->categoryView->showCategoryForm();
    }

    /*
    Metodo que almacena nueva categoria a partir
    de datos en POST, en caso de datos(no vacios) se crea la
    nueva categoria y redirige a lista de categorias.
    En caso de datos vacios muestra pantalla con mensaje
    de error. */
    function storeCategory(){
        $this->checkAdmin();
        $categoryName = $_POST['catname'];
        if(!empty($categoryName)){
            $this->categoryModel->addCategory($categoryName);
            header('Location: ' . BASE_URL . '/category');
        }else{
            $storeError = "La nueva categoría no puede guardar un valor vacío, regrese e intente con nuevos datos.";
            $this->errorCategory($storeError);
        }
    }

    /*
    Metodo que recibe ID de categoria por parametro, obtiene la
    categoria y en caso de que exista redirecciona a vista de
    formulario de edicion de categoria. En caso de ID
    no existente, muestra pantalla de error con mensaje. */
    function editCategory($id){
        $this->checkAdmin();
        $category = $this->categoryModel->getCategoriyByID($id);
        if(isset($category) && $category != null){
            $this->categoryView->showCategoryForm($category);
        }else{
            $errorEdit = "La categoría seleccionada para editar no coincide con los datos almacenados, verifique si se encuentra en su lista de categorías.";
            $this->errorCategory($errorEdit);
        }
    }
    
    /*
    Metodo que actualiza categoria a partir
    de datos en POST, en caso de datos(no vacios) se actualizan
    la los datos y redirige a lista de categorias.
    En caso de datos vacios muestra pantalla con mensaje
    de error y mantiene los datos anteriores en la categoria. */
    function updateCategory($id){
        $this->checkAdmin();
        $idcat = intval($id);
        $categoryName = $_POST['catname'];
        if(!empty($categoryName)){
            $this->categoryModel->updateCategory($idcat, $categoryName);
            header('Location: ' . BASE_URL . '/category');
        }else{
            $updateError = "La categoría a actualizar no puede guardar un valor vacío, regrese en intente con nuevos datos.";
            $this->errorCategory($updateError);
        }
    }

    /*
    Metodo de eliminacion de categoria mediante
    ID obtenido por parametro. En caso de coincidir con
    registro en DB, se elimina el registro y redirige a home.
    En caso de no coincidir muestra pantalla de error. */
    function deleteCategory($id){
        $this->checkAdmin();
        $category = $this->categoryModel->getCategoriyByID($id);
        if(isset($category) && $category != null){
            $this->categoryModel->deleteCategory($id);
            header('Location: ' . BASE_URL . '/');
        }else{
            $deleteError = "La categoría a eliminar no existe, por favor verifique los datos nuevamente.";
            $this->errorCategory($deleteError);
        }
    }

    /*
    Metodo de redireccion a pantalla de error
    con mensaje especifico obtenido por parametro. */
    function errorCategory(String $catError){
        $this->categoryView->showErrorCategory($catError);
    }
}