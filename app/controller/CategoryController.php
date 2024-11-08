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

    function viewAllCategories(){
        $categories = $this->categoryModel->getAllCategories();
        $this->categoryView->showAllCategories($categories);
    }

    function createCategory(){
        $this->checkAdmin();
        $this->categoryView->showCategoryForm();
    }

    function storeCategory(){
        $this->checkAdmin();
        $categoryName = $_POST['catname'];
        $this->categoryModel->addCategory($categoryName);
        header('Location: ' . BASE_URL . '/');
    }

    function editCategory($id){
        $this->checkAdmin();
        $category = $this->categoryModel->getCategoriyByID($id);
        $this->categoryView->showCategoryForm($category);
    }
    
    function updateCategory($id){
        $this->checkAdmin();
        $idcat = intval($id);
        $categoryName = $_POST['catname'];
        $this->categoryModel->updateCategory($idcat, $categoryName);
        header('Location: ' . BASE_URL . '/');
    }

    function deleteCategory($id){
        $this->checkAdmin();
        $this->categoryModel->deleteCategory($id);
        header('Location: ' . BASE_URL . '/');
    }

    function errorCategory(){
        $this->categoryView->showErrorCategory();
    }
}