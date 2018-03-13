<?php

/* 
 Class-connector to DB
 */

class Db {
    public static function getConnection() {
        $paramsPath = ROOT . '/config/db_params.php';
        $params = include($paramsPath);
        
        //Создаем объект класса PDO
        try {
        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
		$db = new PDO($dsn, $params['user'], $params['password']);
		$db->exec("set names utf8");
		
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
        } catch (PDOException $e) {
            echo 'Подключение не удалось: ' . $e->getMessage();
        }

		return $db;
    }
    
}
