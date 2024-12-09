<?php
require_once 'app/model/CategoryModel.php';
require_once 'app/model/ProductModel.php';
require_once 'app/view/CategoryView.php';
require_once 'app/controller/AuthController.php';

class CategoryController extends AuthController{
    private $categoryModel;
    private $productModel;
    private $categoryView;

    function __construct(){
        parent::__construct();
        $this->categoryModel = new CategoryModel();
        $this->productModel = new ProductModel();
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
            if($_FILES['catimage']['type'] == "image/jpg"
            || $_FILES['catimage']['type'] == "image/jpeg"
            || $_FILES['catimage']['type'] == "image/png"){
                $imagen = $_FILES['catimage']['name'];
                $tmp_name = $_FILES['catimage']['tmp_name'];
                $path = "images/" . uniqid("", true) . "." . strtolower(pathinfo($_FILES['catimage']['name'], PATHINFO_EXTENSION));
    
                if(move_uploaded_file($tmp_name, $path)){
                    $this->categoryModel->addCategory($categoryName, $path);
                }
            }else{
                $this->categoryModel->addCategory($categoryName, NULL);
            }
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
        $category = $this->categoryModel->getCategoryByID($id);
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

        $categoryName = $_POST['catname'];
        
        $category = $this->categoryModel->getCategoryByID($id);

        if(!empty($categoryName)){
            if($_FILES['catimage']['type'] == "image/jpg"
            || $_FILES['catimage']['type'] == "image/jpeg"
            || $_FILES['catimage']['type'] == "image/png"){
                $tmp_name = $_FILES['catimage']['tmp_name'];
                $path = "images/" . uniqid("", true) . "." . strtolower(pathinfo($_FILES['catimage']['name'], PATHINFO_EXTENSION));                
                
                if(move_uploaded_file($tmp_name, $path)){
                    $this->categoryModel->updateCategory($id, $categoryName, $path);
                    header('Location: ' . BASE_URL . '/category');
                }else{
                    $updateError = "Error al subir imagen de la categoría.";
                    $this->errorCategory($updateError);
                }
            }else if($category->catimage != null){
                $this->categoryModel->updateCategory($id, $categoryName, $category->catimage);
                header('Location: ' . BASE_URL . '/category');
            }else{
                $this->categoryModel->updateCategory($id, $categoryName, null);
                header('Location: ' . BASE_URL . '/category');
            }
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
        $category = $this->categoryModel->getCategoryByID($id);
        if($category){
            $products = $this->productModel->getProductsByCategoryID($category->idcat);
            if(count($products) > 0){
                foreach($products as $product){
                    $this->productModel->updateProductCategory($product->idproduct);
                }
            }
            
            $this->categoryModel->deleteCategory($category->idcat);
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