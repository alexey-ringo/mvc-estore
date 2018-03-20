<?php

class CabinetController {
    /**
     * Перенаправление на страницу личного кабинета
     * авып
    */ 
    public function actionIndex() {
        //Если пользователь, рвущийся на страницу ЛК авторизирован -
        // метод checkLogged() вернет его id
        $userId = User::checkLogged();
        //echo $userId;
        //Получим записанное в массив имя вошедшего в кабинет пользователя
        $user = User::getUserById($userId);
        
        require_once(ROOT . '/views/cabinet/index.php');
        return true;
    }
    
    /**Редактирование пользователем своего профиля в ЛК
     * Изменение своего имени и пароля
    */ 
    public function actionEdit() {
        //Получаем id-пользоватетя из сессии
        $userId = User::checkLogged();
        
        //Получаем инф о пользователе из БД (в массиве)
        $user = User::getUserById($userId);
        
        //раскладываем логин и пароль в отдельные переменные
        $name = $user['name'];
        $password = $user['password'];
        
        //Установка возвращаемого моделью редактирования значения в пероначальное сост.
        $result = false;
        //Первоначально выполнение кода переместится в отображение /views/cabinet/edit.php
        
        
        //После применения пользователем редактирвоания:
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $password = $_POST['password'];
            
            $errors = false;
            
            //Валидируем измененные пользователем данные
            if (!User::checkName($name)) {
                $errors[] = 'Имя не должно быть короче двух символов!';
            }
            
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче шести символов!';
            }
        
            //All checks are done - begin to save changed data
            if ($errors == false) {
                $result = User::edit($userId, $name, $password);
            }
        }
        
        require_once(ROOT . '/views/cabinet/edit.php');
        return true;
    }
}