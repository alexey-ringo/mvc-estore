<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return array(
    'product/([0-9]+)' => 'product/view/$1', //actionView in ProductController
    
    'catalog' => 'catalog/index', //actionIndex in CatalogController
    'category/([0-9]+)' => 'catalog/category/$1', //actionCategory in CatalogController
    
    'user/register' => 'user/register', //UserController in actionRegister
    
    '' => 'site/index', //actionIndex in SiteController
    );