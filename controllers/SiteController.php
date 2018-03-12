<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once ROOT . '/models/Category.php';
include_once ROOT . '/models/Product.php';

class SiteController {
    
    public function actionIndex() {
        
        /*Receive list of categories and send it to view */
        $categories = array();
        $categories = Category::getCategoriesList();
        
        /*Receive list of latest products and send it to view */
        $latestProducts = array();
        $latestProducts = Product::getLatestProducts(3);
        
        require_once(ROOT . '/views/site/index.php');
        return true;
    }
    
}