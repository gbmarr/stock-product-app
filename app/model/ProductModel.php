<?php
require_once 'Model.php';

class ProductModel extends Model{

    function getAllProducts(){
        $query = "SELECT `idproduct`, P.`name`, `description`, P.`idcategory`, C.`idcat`, C.`name` catdescription, `price`, `stock`, `imgproduct` FROM `products` P, `categories` C WHERE `idcategory` = `idcat`";
        $products = $this->executeQuery($query);
        return $products->fetchAll(PDO::FETCH_OBJ);
    }

    function getProductByID($id){
        $query = "SELECT `idproduct`, P.`name`, `description`, P.`idcategory`, C.`idcat`, C.`name` catdescription, `price`, `stock`, `imgproduct` FROM `products` P, `categories` C WHERE `idcategory` = `idcat` AND `idproduct` = ?";
        $product = $this->executeQuery($query, [$id]);
        return $product->fetch(PDO::FETCH_OBJ);
    }

    function addProduct($name, $desc, $idcat, $price, $stock, $imgproduct){
        $query = "INSERT INTO `products` (`name`, `description`, `idcategory`, `price`, `stock`, `imgproduct`) VALUES (?, ?, ?, ?, ?, ?)";
        $this->executeQuery($query, [$name, $desc, $idcat, $price, $stock, $imgproduct]);
    }

    function updateProduct($id, $name, $desc, $idcat, $price, $stock, $imgproduct){
        $query = "UPDATE `products` SET `name` = ?, `description` = ?, `idcategory` = ?, `price` = ?, `stock` = ?, `imgproduct` = ? WHERE `idproduct` = ?";
        $this->executeQuery($query, [$name, $desc, $idcat, $price, $stock, $imgproduct, $id]);
    }

    function deleteProduct($id){
        $query = "DELETE FROM `products` WHERE `idproduct` = ?";
        $this->executeQuery($query, [$id]);
    }
}