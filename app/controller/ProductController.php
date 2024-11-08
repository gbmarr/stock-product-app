<?php
require_once './app/view/ProductView.php';
require_once './app/model/ProductModel.php';
require_once './app/model/CategoryModel.php';
require_once './app/controller/AuthController.php';

class ProductController extends AuthController{
    private $view;
    private $productModel;
    private $categoryModel;

    function __construct(){
        $this->view = new ProductView();
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    function viewAllProducts(){
        $products = $this->productModel->getAllProducts();
        $this->view->showAllProducts($products);
    }

    function viewAllProductsList(){
        $products = $this->productModel->getAllProducts();
        $this->view->showAllProductsList($products);
    }

    function detailProduct($id){
        $product = $this->productModel->getProductByID($id);
        $this->view->showProductDetail($product);
    }

    function createProduct(){
        $this->checkAdmin();
        $categories = $this->categoryModel->getAllCategories();
        $this->view->showProductForm(null, $categories);
    }

    function storeProduct(){
        $this->checkAdmin();
        $name = $_POST['name'];
        $desc = $_POST['description'];
        $idcat = $_POST['idcategory'] ? intval($_POST['idcategory']) : 1;
        $stock = boolval($_POST['stock']);
        $price = $_POST['price'];

        if($_FILES['imgproduct']['type'] == "image/jpg"
        || $_FILES['imgproduct']['type'] == "image/jpeg"
        || $_FILES['imgproduct']['type'] == "image/png"){
            $imagen = $_FILES['imgproduct']['name'];
            $tmp_name = $_FILES['imgproduct']['tmp_name'];
            $path = "images/" . uniqid("", true) . "." . strtolower(pathinfo($_FILES['imgproduct']['name'], PATHINFO_EXTENSION));

            if(move_uploaded_file($tmp_name, $path)){
                $this->productModel->addProduct($name, $desc, $idcat, $price, $stock, $path);
            }
        }else{
            $this->productModel->addProduct($name, $desc, $idcat, $price, $stock, NULL);
        }
        header('Location: ' . BASE_URL . '/');
    }

    function editProduct($id){
        $this->checkAdmin();
        $product = $this->productModel->getProductByID($id);
        $categories = $this->categoryModel->getAllCategories();
        $this->view->showProductForm($product, $categories);
    }

    function updateProduct($id){
        $this->checkAdmin();
        $name = $_POST['name'];
        $desc = $_POST['description'];
        $idcat = $_POST['idcategory'] ? intval($_POST['idcategory']) : 1;
        $stock = boolval($_POST['stock']);
        $price = $_POST['price'];
        
        $producto = $this->productModel->getProductByID($id);

        if($_FILES['imgproduct']['type'] == "image/jpg"
        || $_FILES['imgproduct']['type'] == "image/jpeg"
        || $_FILES['imgproduct']['type'] == "image/png"){
            $imagen = $_FILES['imgproduct']['name'];
            $tmp_name = $_FILES['imgproduct']['tmp_name'];
            $path = "images/" . uniqid("", true) . "." . strtolower(pathinfo($_FILES['imgproduct']['name'], PATHINFO_EXTENSION));

            if(move_uploaded_file($tmp_name, $path)){
                $this->productModel->updateProduct($id, $name, $desc, $idcat, $price, $stock, $path);
            }
        }else if($producto->imgproduct != NULL){
            $this->productModel->updateProduct($id, $name, $desc, $idcat, $price, $stock, $producto->imgproduct);
        }else{
            $this->productModel->updateProduct($id, $name, $desc, $idcat, $price, $stock, NULL);
        }
        header('Location: ' . BASE_URL . '/');
    }

    function deleteProduct($id){
        $this->checkAdmin();
        $this->productModel->deleteProduct($id);
        header('Location: ' . BASE_URL . '/');
    }

    function errorProduct(){}
}