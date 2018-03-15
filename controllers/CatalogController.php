<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//include_once ROOT . '/models/Category.php';
//include_once ROOT . '/models/Product.php';

class CatalogController {
    
    public function actionIndex() {
        
        /*Receive list of categories (for menu) and send it to view */
        $categories = array();
        $categories = Category::getCategoriesList();
        
        /*Receive list of latest products and send it to view */
        $latestProducts = array();
        $latestProducts = Product::getLatestProducts();
        
        require_once(ROOT . '/views/catalog/index.php');
        return true;
    }
    
    //method receive choose category and output all products in this category
    public function actionCategory($categoryId) {
        
        /*Receive list of categories (for menu) and send it to view */
        $categories = array();
        $categories = Category::getCategoriesList();
        
        /*Receive list of all products in choose category and send it to view */
        $categoryProducts = array();
        $categoryProducts = Product::getProductsListByCategory($categoryId);
        
        require_once(ROOT . '/views/catalog/category.php');
        return true;
    }
    
}