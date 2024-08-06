<?php
require_once 'Model.php';

class CategoryModel extends Model{

    function getAllCategories(){
        $query = "SELECT `idcat`, `name` FROM `categories`";
        $categories = $this->executeQuery($query);
        return $categories->fetchAll(PDO::FETCH_OBJ);
    }

    function getCategoriyByID($id){
        $query = "SELECT `idcat`, `name` FROM `categories` WHERE `idcat` = ?";
        $category = $this->executeQuery($query, [$id]);
        return $category->fetch(PDO::FETCH_OBJ);
    }

    function addCategory($newCat){
        $query = "INSERT INTO `categories` (`name`) VALUES (?)";
        $this->executeQuery($query, [$newCat]);
    }

    function updateCategory($id, $categoryName){
        $query = "UPDATE `categories` SET `name` = ? WHERE `idcat` = ?";
        $this->executeQuery($query, [$categoryName, $id]);
    }

    function deleteCategory($id){
        $query = "DELETE FROM `categories` WHERE `idcat` = ?";
        $this->executeQuery($query, [$id]);
    }
}