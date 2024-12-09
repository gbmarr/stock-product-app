<?php
require_once 'Model.php';

class ProductModel extends Model{
    private $IMGDEFAULT;
    private $ID_CAT_DEFAULT;

    public function __construct() {
        parent::__construct();
        $this->IMGDEFAULT = "images/imagenPorDefault.jpg";
        $this->ID_CAT_DEFAULT = 1;
    }

    /*
    Metodo de consulta que obtiene todos los registros existentes en tabla de products con sus
    ID-NOMBRE-DESCRIPCION-ID DE CATEGORIA-DESCRIPCION DE CATEGORIA-PRECIO-STOCK-IMAGEN y luego los retorna. */
    function getAllProducts(){
        $query = "SELECT `idproduct`, P.`prodname`, `description`, P.`idcategory`, C.`idcat`, C.`catname` catdescription, `price`, `stock`, `imgproduct` FROM `products` P, `categories` C WHERE `idcategory` = `idcat`";
        $products = $this->executeQuery($query);
        return $products->fetchAll(PDO::FETCH_OBJ);
    }

    /*
    Metodo que recibe ID por parametro y consulta la existencia de
    un producto que coincida con el mismo para luego retornarlo. */
    function getProductByID($id){
        $query = "SELECT `idproduct`, P.`prodname`, `description`, P.`idcategory`, C.`idcat`, C.`catname` catdescription, `price`, `stock`, `imgproduct` FROM `products` P, `categories` C WHERE `idcategory` = `idcat` AND `idproduct` = ?";
        $product = $this->executeQuery($query, [$id]);
        return $product->fetch(PDO::FETCH_OBJ);
    }

    /*
    Metodo que recibe ID de categoria por parametro y consulta los registros existentes de
    productos que coincidan con el mismo para luego retornarlos. */
    function getProductsByCategoryID($id){
        $query = "SELECT `idproduct`, P.`prodname`, `description`, P.`idcategory`, C.`idcat`, C.`catname` catdescription, `price`, `stock`, `imgproduct` FROM `products` P, `categories` C WHERE `idcategory` = `idcat` AND `idcat` = ?";
        $products = $this->executeQuery($query, [$id]);
        return $products->fetchAll(PDO::FETCH_OBJ);
    }

    /*
    Metodo que recibe nombre, descripcion, id de categoria, precio, stock e imagen
    de una nueva categoria por parametro. Evalua si la imagen recibida es nula y
    luego realiza un INSERT en la tabla categories con el nuevo registro.*/
    function addProduct($name, $desc, $idcat, $price, $stock, $imgproduct){
        $imgproduct = $this->imgValidate($imgproduct);
        
        $query = "INSERT INTO `products` (`prodname`, `description`, `idcategory`, `price`, `stock`, `imgproduct`) VALUES (?, ?, ?, ?, ?, ?)";
        $this->executeQuery($query, [$name, $desc, $idcat, $price, $stock, $imgproduct]);
    }

    /*
    Metodo que actualiza un registro en tabla products mediante el ID recibiendo los datos de
    nombre, descripcion, id de categoria, precio, stock e imagen por parametro.
    Evalua si la imagen recibida es nula y luego realiza un UPDATE en la tabla categories con el nuevo registro.*/
    function updateProduct($id, $name, $desc, $idcat, $price, $stock, $imgproduct){
        $imgproduct = $this->imgValidate($imgproduct);

        $query = "UPDATE `products` SET `prodname` = ?, `description` = ?, `idcategory` = ?, `price` = ?, `stock` = ?, `imgproduct` = ? WHERE `idproduct` = ?";
        $this->executeQuery($query, [$name, $desc, $idcat, $price, $stock, $imgproduct, $id]);
    }

    /*
    Metodo que actualiza la categoría de un registro en la tabla products para los
    casos en los que se haya eliminado una categoría.*/
    function updateProductCategory($id){
        $query = "UPDATE `products` SET `idcategory` = ? WHERE `idproduct` = ?";
        $this->executeQuery($query, [$this->ID_CAT_DEFAULT, $id]);
    }

    /*
    Metodo que recibe ID por parametro y realiza un DELETE del
    registro en tabla products que coincida con el mismo. */
    function deleteProduct($id){
        $query = "DELETE FROM `products` WHERE `idproduct` = ?";
        $this->executeQuery($query, [$id]);
    }

    /*
    Metodo de validacion de imagen recibiendo a la misma por
    parametro. En caso de ser diferente a null,
    se retorna la imagen(path), en caso contrario se retorna una
    imagen por defecto(path predeterminado a otra imagen 'default'). */
    function imgValidate($image){
        if(is_null($image) || empty($image)){
            $image = $this->IMGDEFAULT;
        }
        return $image;
    }
}