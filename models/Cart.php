<?php

class Cart {
    /**
     * Добавление товара в корзину (сессию)
     * @param int $id <p>id товара</p>
     * @return integer <p>Количество товаров в корзине</p>
     */
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
            // Если такой товар уже был до этого в корзине, но сейчас был добавлен еще раз, увеличим количество на 1
            $productsInCart[$id] ++;
        } else {
            // Если этого товара еше не было в корзине, то добавляем id нового товара в корзину с количеством 1
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
        
        //Сразу, по результату выполнения метода addProduct() - подсчитывать кол0во товаров в корзине
        //т.е. - не дожидаясь, когда страница view обновиться и cuuntItems() будет запрошен из view
        //Это нужно для actionAddAjax
        return self::countItems();
    }
    
    /**
     * Удаляет товар с указанным id из корзины
     * @param integer $id <p>id товара</p>
     */
    public static function deleteProduct($id) {
        // Приводим $id к типу integer
        $id = intval($id);
        
        // Получаем массив с идентификаторами и количеством товаров в корзине
        $productsInCart = self::getProducts();
        
        // Удаляем из массива элемент с указанным id
        unset($productsInCart[$id]);
         
        // Записываем вновь собранный массив с товарами в сессию
        $_SESSION['products'] = $productsInCart;
        return true;
        
    }
    
    /**
     * Подсчет количество товаров в корзине (в сессии)
     * @return int <p>Количество товаров в корзине</p>
     */
    public static function countItems() {
        
        // Проверка наличия товаров в корзине
        if(isset($_SESSION['products'])) {
            // Если массив с товарами есть
            // Подсчитаем и вернем их количество
            $count = 0;
            foreach($_SESSION['products'] as $id => $quantity) {
                $count = $count + $quantity;
            }
            return $count;
        }
        else {
            // Если товаров нет, вернем 0
            return 0;
        }
    }
    
    /**
     * Возвращает массив с идентификаторами и количеством товаров в корзине<br/>
     * Если товаров нет, возвращает false;
     * @return mixed: boolean or array
     */
    public static function getProducts()
    {
        if (isset($_SESSION['products'])) {
            return $_SESSION['products'];
        }
        return false;
    }
    
    /**
     * Получаем общую стоимость переданных товаров
     * @param array $products <p>Массив с информацией о товарах</p>
     * @return integer <p>Общая стоимость</p>
     */
    public static function getTotalPrice($products)
    {
        // Получаем массив с идентификаторами и количеством товаров в корзине
        $productsInCart = self::getProducts();
        // Подсчитываем общую стоимость
        $total = 0;
        if ($productsInCart) {
            // Если в корзине не пусто
            // Проходим по переданному в метод массиву товаров
            foreach ($products as $item) {
                // Находим общую стоимость: цена товара * количество товара
                $total += $item['price'] * $productsInCart[$item['id']];
            }
        }
        return $total;
    }
    
    //Очистка корзины
    public static function clear() {
        //Если в массиве сесии установлено значение products
        if(isset($_SESSION['products'])) {
            //то удаляем его
            unset($_SESSION['products']);
        }
        
    }
}