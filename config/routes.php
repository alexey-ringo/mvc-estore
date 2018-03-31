<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return array(
    // Товар:
    'product/([0-9]+)' => 'product/view/$1', //actionView in ProductController
    
    // Каталог:
    'catalog' => 'catalog/index', //actionIndex in CatalogController
    
    // Категория товаров:
    'category/([0-9]+)/page-([0-9]+)' => 'catalog/category/$1/$2', // actionCategory в CatalogController
    'category/([0-9]+)' => 'catalog/category/$1', //actionCategory in CatalogController
    
    // Корзина:
    'cart/checkout' => 'cart/checkout', //actionCheckout in CatalogController
    'cart/add/([0-9]+)' => 'cart/add/$1', //actionAdd in CartController
    'cart/addAjax/([0-9]+)' => 'cart/addAjax/$1', //actionAddAjax in CartController
    'cart/delete/([0-9]+)' => 'cart/delete/$1', //actionDelete in CartController
    'cart' => 'cart/index', // actionIndex in CartController
    
    // Пользователь:
    'user/register' => 'user/register',
    'user/login' => 'user/login',
    'user/logout' => 'user/logout',
    'cabinet/edit' => 'cabinet/edit',
    'cabinet' => 'cabinet/index',
    
    // Управление товарами:    
    'adminka/product/create' => 'adminProduct/create',
    'adminka/product/update/([0-9]+)' => 'adminProduct/update/$1',
    'adminka/product/delete/([0-9]+)' => 'adminProduct/delete/$1',
    'adminka/product' => 'adminProduct/index',
    
    // Управление категориями:    
    'adminka/category/create' => 'adminCategory/create',
    'adminka/category/update/([0-9]+)' => 'adminCategory/update/$1',
    'adminka/category/delete/([0-9]+)' => 'adminCategory/delete/$1',
    'adminka/category' => 'adminCategory/index',
    
    // Управление заказами:    
    'adminka/order/update/([0-9]+)' => 'adminOrder/update/$1',
    'adminka/order/delete/([0-9]+)' => 'adminOrder/delete/$1',
    'adminka/order/view/([0-9]+)' => 'adminOrder/view/$1',
    'adminka/order' => 'adminOrder/index',
    
    // Админпанель:
    'adminka' => 'admin/index',
    
    // О магазине
    'contacts' => 'site/contact',
    'about' => 'site/about',
    
    // Главная страница
    'index.php' => 'site/index', // actionIndex в SiteController
    '' => 'site/index', // actionIndex в SiteController
    
    );