<?php

class User {
    /**
     * Write down into DB all users params -  $name $email и $password
     * @param string $name
     * @param string $email
     * @param string $password
     * return bool
    */
    public static function register($name, $email, $password) {
        $db = Db::getConnection();
        $sql = 'INSERT INTO user (name, email, password) '
                . 'VALUES (:name, :email, :password)';
                
        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        
        return $result->execute();
        
        //return true;
    }
    
    
    /**
     * Check User Neme - must have no less than 2 symbols
     * @param string $name
     * return bool
    */
    public static function checkName($name) {
        if (strlen($name) >= 2) {
            return true;
        }
        return false;
    }
    
    /**
     * Check password - must have no less than 6 symbols
     * @param string $password
     * return bool
    */
    public static function checkPassword($password) {
        if (strlen($password) >= 6) {
            return true;
        }
        return false;
    }
    
    /**
     * Validate email
     * @param string $email
     * return bool
    */
    public static function checkEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
    
    public static function checkEmailExists($email) {
        
        $db = Db::getConnection();
        
        $sql = 'SELECT COUNT(*) FROM user WHERE email = :email';
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        
        $result->execute();
        
        if ($result->fetchColumn()) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Проверка в БД существования пользователя с заданными $email и $password
     * param string $email
     * param string $password
     * return mixed : integer user id or false
    */
    public static function checkUserData($email, $password) {
        
        $db = Db::getConnection();
        
        $sql = 'SELECT * FROM user WHERE email = :email AND password = :password';
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_INT);
        $result->bindParam(':password', $password, PDO::PARAM_INT);
        $result->execute();
        
        $user = $result->fetch();
        if ($user) {
            return $user['id'];
        }
        
        return false;
    }
    
    
    /**
     * Start 
     * 
     * 
    */
    public static function auth($userId) {
        //Открываем сессию и записываем id-пользователя в массив
        //session_start();
        $_SESSION['user'] = $userId;
    } 
    
    /**
     * Проверка наличия активной сессии
     * 
    */
    public static function checkLogged() {
        //session_start();
        if(isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        //В случае отсутствия сессии перенаправляем пользователя на страничку входа (ввода пароля)
        header("Location: /user/login");
    }
    
    public static function isGuest() {
        //session_start();
        if (isset($_SESSION['user'])) {
            //Если сессии нет - значит это гость
            return false;
        }
        //В обратном случае видим наличие сессии и возвращаем признак авторизованного пользователя
        return true;
    }
    
    /**
     * Возвращает пользователя с указанным id
     * @param integer $id <p>id пользователя</p>
     * @return array <p>Массив с информацией о пользователе</p>
     */ 
    public static function getUserById($id) {
        if ($id) {
            $db = Db::getConnection();
            //with placeholder
            $sql = 'SELECT * FROM user WHERE id = :id';
            
            $result = $db->prepare($sql);
            $result->bindParam(':id', $id, PDO::PARAM_INT);
            
            //Указываем, что хотим получить данные ввиде массива
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result->execute();
            
            return $result->fetch();
            
        }
    }
    
    /**
     * Редактирование данных пользователя
     * @param integer $id <p>id пользователя</p>
     * @param string $name <p>Имя</p>
     * @param string $password <p>Пароль</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function edit ($id, $name, $password) {
        // Соединение с БД
        $db = Db::getConnection();
        // Текст запроса к БД
        $sql = "UPDATE user 
            SET name = :name, password = :password 
            WHERE id = :id";
        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        return $result->execute();
        
    }
}