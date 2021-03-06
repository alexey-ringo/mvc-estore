<?php
/**
 * Класс Order - модель для работы с заказами
 */
 
 class Order {
      /**
     * Сохранение заказа 
     * @param string $userName <p>Имя</p>
     * @param string $userPhone <p>Телефон</p>
     * @param string $userComment <p>Комментарий</p>
     * @param integer $userId <p>id пользователя</p>
     * @param array $products <p>Массив с товарами</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
     public static function save($userName, $userPhone, $userComment, $userId, $products) {
        // Соединение с БД
        $db = Db::getConnection();
        
        /*
        echo gettype($products);
        echo '<pre>';
        echo print_r($products);
        echo '</pre>';
        */
        
        $products = json_encode($products);
        
        /*
        echo gettype($products);
        echo '<pre>';
        echo print_r($products);
        echo '</pre>';
        */
        
         // Текст запроса к БД
        $sql = 'INSERT INTO product_order (user_name, user_phone, user_comment, user_id, products) '
                . 'VALUES (:user_name, :user_phone, :user_comment, :user_id, :products)';
                
        $result = $db->prepare($sql);
        $result->bindParam(':user_name', $userName, PDO::PARAM_STR);
        $result->bindParam(':user_phone', $userPhone, PDO::PARAM_STR);
        $result->bindParam(':user_comment', $userComment, PDO::PARAM_STR);
        $result->bindParam(':user_id', $userId, PDO::PARAM_STR);
        $result->bindParam(':products', $products, PDO::PARAM_STR);
        
        /*
        $result->execute();
        die();
        */
        return $result->execute();
            

     }
 }