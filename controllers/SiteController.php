<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once ROOT . '/models/Category.php';


class SiteController {
    
    public function actionIndex() {
        
        $categories = array();
        $categories = Category::getCategoriesList();
        
        require_once(ROOT . '/views/site/index.php');
        return true;
    }
    
}