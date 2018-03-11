<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Front Contriller
//1. Общие настройки
//1.1 Включаем отображение ошибок
ini_set('display_errors', 1);
error_reporting(E_ALL);
        
//2. Подключение файлов системы
//2.1 Подключаем компонент Router
define('ROOT', dirname(__FILE__));


require_once(ROOT . '/components/Router.php');
        
//3. Установка соединения с БД
require_once(ROOT . '/components/Db.php');
        
        
        
//Вызов Router
$router = new Router;
$router->run();