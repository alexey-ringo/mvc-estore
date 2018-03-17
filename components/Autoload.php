<?php

//PHP передает сюда названия всех искомых классов
function __autoload($class_name) {
    
    //Папки, где могут содержаться нужные классы
    $array_paths = array(
        '/models/',
        '/components/'
        );
    
    //Проходим циклом по каждой из папок и ищем нужный файл с нужным классом
    
    foreach ($array_paths as $path) {
        $path = ROOT . $path . $class_name . '.php';
        //Если нашли - подключаем
        if (is_file($path)) {
            include_once $path;
        }
    }
    
}