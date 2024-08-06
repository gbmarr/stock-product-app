<?php
require_once 'View.php';

class CategoryView extends View{

    function showAllCategories($categories){
        $this->smarty->assign('categories', $categories);
        $this->smarty->display('categories/categoryList.tpl');
    }

    function showCategoryForm($category = null){
        $this->smarty->assign('category', $category);
        $this->smarty->display('categories/categoryForm.tpl');
    }

    function showErrorCategory(){
        $this->smarty->display('error/error.tpl');
    }
}