<?php

require_once 'app/controller/ProductController.php';
require_once 'app/controller/CategoryController.php';
require_once 'app/controller/AuthController.php';
require_once 'BASE_URL.php';

$categoryController = new CategoryController();
$authController = new AuthController();
$productController = new ProductController();

$action = empty($_GET['action']) ? '' : $_GET['action'];
$param = explode('/', $action);

switch ($param[0]){
    case '':
    case 'home':
        // muestra el home con productos en formato cards
        $productController->viewAllProducts();
        break;
    case 'list':
        // muestra el home con productos en formato lista
        $productController->viewAllProductsList();
        break;
    case 'add':
        // muestra form para agregar nuevo producto
        $productController->createProduct();
        break;
    case 'store':
        // almacena el nuevo producto
        $productController->storeProduct();
        break;
    case 'edit':
        // muestra form para editar producto existente
        $id = isset($param[1]) ? $param[1] : 0;
        isset($id) ? $productController->editProduct($id) : $productController->errorProduct();
        break;
    case 'update':
        // actualiza el producto editado
        $id = isset($param[1]) ? $param[1] : 0;
        isset($id) ? $productController->updateProduct($id) : $productController->errorProduct();
        break;
    case 'detail':
        // muestra vista de un solo producto
        $id = isset($param[1]) ? $param[1] : null;
        $id ? $productController->detailProduct($param[1]) : $productController->errorProduct();
        break;
    case 'delete':
        // elimina un producto existente
        isset($param[1]) ? $productController->deleteProduct($param[1]) : $productController->errorProduct();
        break;
    case 'login':
        // muestra form de inicio de sesión
        $authController->login();
        break;
    case 'logout':
        // desloguea usuario logueado
        $authController->logout();
        break;
    case 'auth':
        // valida el login
        $authController->authenticate();
        break;
    case 'register':
        // agrega nuevo usuario y loguea
        $authController->register();
        break;
        case 'registeruser':
        // muestra form de registro de usuario
        $authController->registerForm();
        break;
    case 'category':
        if(isset($param[1])){
            switch($param[1]){
                case 'add':
                    // redirige a form para agregar categoria
                    $categoryController->createCategory();
                    break;
                case 'store':
                    // almacena nueva categoría
                    $categoryController->storeCategory();
                    break;
                case 'edit':
                    // redirige a form para editar categoria existente
                    isset($param[2]) ? $categoryController->editCategory($param[2]) : $categoryController->errorCategory();
                    break;
                case 'update':
                    // guarda cambios efectuados en categoria existente
                    isset($param[2]) ? $categoryController->updateCategory($param[2]) : $categoryController->errorCategory();
                    break;
                case 'delete':
                    // elimina categoria
                    isset($param[2]) ? $categoryController->deleteCategory($param[2]) : $categoryController->errorCategory();
                    break;
                default:
                // muestra todas las categorias
                $categoryController->viewAllCategories();
                break;
            }
        }else{
            $categoryController->viewAllCategories();
        }
        break;
    default:
    $productController->viewAllProducts();
    break;
}