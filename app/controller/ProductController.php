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

    /*
    Metodo que obtiene el total de registros de productos de la DB y los envia a vista
    de productos para mostrar en formato card. */
    function viewAllProducts(){
        $products = $this->productModel->getAllProducts();
        $this->view->showAllProducts($products);
    }

    /*
    Metoto que obtiene el total de registros de productos de la DB y los envia a vista
    de productos en formato lista.*/
    function viewAllProductsList(){
        $categories = $this->categoryModel->getAllCategories();
        $filter = isset($_POST['category_filter']) ? intval($_POST['category_filter']) : null;

        if(!empty($filter) && isset($filter)){
            $products = $this->productModel->getProductsByCategoryID($filter);
        }else{
            $products = $this->productModel->getAllProducts();
        }
        $admin = $this->isAdmin();
        $this->view->showAllProductsList($products, $categories, $filter, $admin);
    }

    /*
    Metodo que obtiene ID de producto por parametro, verifica si existe registro con ese ID y en caso
    positivo muestra pantalla de detalle con datos del producto. En caso de no existir el producto,
    muestra pantalla de error con mensaje y posible accion. */
    function detailProduct($id){
        $product = $this->productModel->getProductByID($id);
        if(isset($product) && $product != null){
            $this->view->showProductDetail($product);
        }else{
            $this->errorProduct("El producto seleccionado no existe, por favor verifique si se encuentra en su lista de productos.");
        }
    }

    /*
    Metodo que chequea que el usuario tenga acceso permitido a esta accion, obtiene lista de categorias y
    redirecciona a vista de formulario de creacion de nuevo producto. */
    function createProduct(){
        $this->checkAdmin();
        $categories = $this->categoryModel->getAllCategories();
        $this->view->showProductForm(null, $categories);
    }

    /*
    Metodo que almacena nuevo producto en DB. Chequea que el usuario tenga acceso, guarda datos del POST
    en variables para los campos del nuevo producto. Si ciertos datos no estan vacios, verifica si el dato
    de imagen es de ciertos tipos, en caso de cumplir, almacena la imagen en folder 'images' y agrega el
    producto a la DB. En caso contrario se almacena el producto con imagen NULL. Luego se redirige a home.
    Si se enviaron datos vacios en el POST, se redirecciona a pantalla de error con mensaje y posible accion. */
    function storeProduct(){
        $this->checkAdmin();
        $name = $_POST['name'];
        $desc = $_POST['description'];
        $idcat = $_POST['idcategory'] ? intval($_POST['idcategory']) : 1;
        $stock = isset($_POST['stock']) ? true : false;
        $price = $_POST['price'];

        if(!empty($name) && !empty($desc) && !empty($price)){
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
                $this->productModel->addProduct($name, $desc, $idcat, $price, $stock, null);
            }
            header('Location: ' . BASE_URL . '/');
        }else{
            $errorProduct = "No puedes guardar un nuevo producto con datos vacíos, asegurate de completar todos los campos.";
            $this->errorProduct($errorProduct);
        }
    }

    /*
    Metodo que chequea que el usuario tenga acceso permitido a esta accion, obtiene un producto mediante
    ID y la lista de categorias. En caso de que el producto exista en DB y redirecciona a vista de formulario de
    edicion de producto. En caso contrario, muestra pantalla de error con mensaje. */
    function editProduct($id){
        $this->checkAdmin();
        $product = $this->productModel->getProductByID($id);
        $categories = $this->categoryModel->getAllCategories();
        if(isset($product) && $product != null){
            $this->view->showProductForm($product, $categories);
        }else{
            $this->errorProduct("El producto seleccionado no existe, por favor verifique si se encuentra en su lista de productos.");
        }
    }

    
    /*
    Metodo que actualiza producto en DB. Chequea que el usuario tenga acceso, guarda datos del POST en
    variables para los campos del producto. Si ciertos datos no estan vacios, verifica si el dato de
    imagen es de ciertos tipos, en caso de cumplir, almacena la nueva imagen en folder 'images' y agrega el
    producto a la DB. En caso contrario se almacena el producto con la imagen anterior si el producto la tuviera
    o NULL. Luego se redirige a home. Si se enviaron datos vacios en el POST, se redirecciona a pantalla de
    error con mensaje y posible accion. */
    function updateProduct($id){
        $this->checkAdmin();
        
        $name = $_POST['name'];
        $desc = $_POST['description'];
        $idcat = $_POST['idcategory'] ? intval($_POST['idcategory']) : 1;
        $stock = isset($_POST['stock']) ? true : false;
        $price = $_POST['price'];
        
        $producto = $this->productModel->getProductByID($id);

        if(!empty($name) && !empty($desc) && !empty($price)){
            if($_FILES['imgproduct']['type'] == "image/jpg"
            || $_FILES['imgproduct']['type'] == "image/jpeg"
            || $_FILES['imgproduct']['type'] == "image/png"){
                $tmp_name = $_FILES['imgproduct']['tmp_name'];
                $path = "images/" . uniqid("", true) . "." . strtolower(pathinfo($_FILES['imgproduct']['name'], PATHINFO_EXTENSION));

                if(move_uploaded_file($tmp_name, $path)){
                    $this->productModel->updateProduct($id, $name, $desc, $idcat, $price, $stock, $path);
                }
            }else if($producto->imgproduct != null){
                $this->productModel->updateProduct($id, $name, $desc, $idcat, $price, $stock, $producto->imgproduct);
            }else{
                $this->productModel->updateProduct($id, $name, $desc, $idcat, $price, $stock, null);
            }
            header('Location: ' . BASE_URL . '/');
        }else{
            $errorProduct = "No puedes editar un producto con datos vacíos, asegurate de completar todos los campos.";
            $this->errorProduct($errorProduct);
        }
    }

    /*
    
    /*
    Metodo que almacena nuevo producto en DB. Chequea que el usuario tenga acceso, obtiene el
    producto de la DB mediante ID pasado por parametro. En caso de coincidir con un registro y
    luego de evaluar que exista y no sea NULL, lo elimina y redirige a home. En caso contrario
    muestra pantalla de error con mensaje. */
    function deleteProduct($id){
        $this->checkAdmin();
        $product = $this->productModel->getProductByID($id);
        if(isset($product) && $product != null){
            $this->productModel->deleteProduct($product->idproduct);
            header('Location: ' . BASE_URL . '/');
        }else{
            $this->errorProduct("El producto seleccionado no existe, por lo tanto no se puede eliminar, por favor verifique si se encuentra en su lista de productos.");
        }
    }

    /*
    Metodo que redirecciona a pantalla de error y muestra mensaje pasado por parametro. */
    function errorProduct(String $productError){
        $this->view->showErrorProduct($productError);
    }
}