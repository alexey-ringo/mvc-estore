<?php

class Cart {
    //Добавить товар в корзину
    public static function addProduct($id) {
        // Приводим $id к типу integer
        $id = intval($id);
        
        // Пустой массив для товаров в корзине
        $productsInCart = array();
        
        // Если в корзине уже есть товары (т.е. - если они уже хранятся в сессии)
        if (isset($_SESSION['products'])) {
            // То заполним наш массив "старыми" товарами из сессии
            $productsInCart = $_SESSION['products'];
        }
        // Проверяем есть ли уже такой товар в корзине 
        if (array_key_exists($id, $productsInCart)) {
            // Если такой товар есть в корзине, но был добавлен еще раз, увеличим количество на 1
            $productsInCart[$id] ++;
        } else {
            // Если нет, добавляем id нового товара в корзину с количеством 1
            $productsInCart[$id] = 1;
        }
        // Записываем вновь собранный массив с товарами в сессию
        $_SESSION['products'] = $productsInCart;
        /*
        echo '<pre>';
        print_r($_SESSION['products']);
        echo '</pre>';
        die();
        */
    }
    
    //Счетчик общего кол-ва товаров в корзине
    public static function countItems() {
        if(isset($_SESSION['products'])) {
            $count = 0;
            foreach($_SESSION['products'] as $id => $quantity) {
                $count = $count + $quantity;
                return $count;
            }
        }
        else {
            return 0;
        }
    }
}