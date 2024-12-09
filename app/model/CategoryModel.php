<?php
require_once 'Model.php';

class CategoryModel extends Model{
    private $IMGDEFAULT;

    public function __construct() {
        parent::__construct();
        $this->IMGDEFAULT = "images/imagenPorDefault.jpg";
    }

    /*
    Metodo de consulta que obtiene todos los registros existentes
    en tabla de categorias con sus ID y NOMBRE y luego los retorna. */
    function getAllCategories(){
        $query = "SELECT `idcat`, `catname`, `catimage` FROM `categories`";
        $categories = $this->executeQuery($query);
        return $categories->fetchAll(PDO::FETCH_OBJ);
    }

    /*
    Metodo que recibe ID por parametro y consulta la existencia de
    una categoria que coincida con el mismo para luego retornarla. */
    function getCategoryByID($id){
        $query = "SELECT `idcat`, `catname`, `catimage` FROM `categories` WHERE `idcat` = ?";
        $category = $this->executeQuery($query, [$id]);
        return $category->fetch(PDO::FETCH_OBJ);
    }

    /*
    Metodo que recibe nombre de una nueva categoria por parametro y
    realiza un INSERT en la tabla categories con el nuevo registro.*/
    function addCategory($categoryName, $catimage){
        $catimage = $this->imgValidate($catimage);

        $query = "INSERT INTO `categories` (`catname`, `catimage`) VALUES (?, ?)";
        $this->executeQuery($query, [$categoryName, $catimage]);
    }

    /*
    Metodo que actualiza registro en tabla categories a partir de
    recibir ID de la categoria y nuevo nombre de la misma.  */
    function updateCategory($id, $categoryName, $catimage){
        $catimage = $this->imgValidate($catimage);

        $query = "UPDATE `categories` SET `catname` = ?, `catimage` = ? WHERE `idcat` = ?";
        $this->executeQuery($query, [$categoryName, $catimage, $id]);
    }

    /*
    Metodo que se encarga de eliminar registro en tabla categories
    a partir de recibir ID por parametro y eliminar el elemento que
    coincida con el mismo. */
    function deleteCategory($id){
        $query = "DELETE FROM `categories` WHERE `idcat` = ?";
        $this->executeQuery($query, [$id]);
    }

    /*
    Metodo de validacion de imagen recibiendo a la misma por
    parametro. En caso de ser diferente a null,
    se retorna la imagen(path), en caso contrario se retorna una
    imagen por defecto(path predeterminado a otra imagen 'default'). */
    function imgValidate(String $image){
        if($image == null){
            $image = $this->IMGDEFAULT;
        }
        return $image;
    }
}