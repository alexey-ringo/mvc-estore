<?php

class UserController {
    
    public function actionRegister() {
        //First initialization string variables in register form
        $name = '';
        $email = '';
        $password = '';
        $result = false;
        
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $errors = false;
            
            if (!User::checkName($name)) {
                $errors[] = 'Имя не должно быть короче двух символов!';
            }
            
            
            if (!User::checkEmail($email)) {
                $errors[] = 'неправильный email!';
            }
            
            
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче шести символов!';
            }
            
            if (User::checkEmailExists($email)) {
                $errors[] = 'Такой email уже используется!';
            }
            
            //All checks are done - begin to save new user
            if ($errors == false) {
                $result = User::register($name, $email, $password);
                
            }
            
        }
        
        
        //User registration page
        require_once(ROOT . '/views/user/register.php');
        
        return true;
    }
    
    
    public function actionLogin() {
        //First initialization string variables in register form
        $email = '';
        $password = '';
        //$result = false;
        
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $errors = false;
            
            
            
            if (!User::checkEmail($email)) {
                $errors[] = 'неправильный email!';
            }
            
            
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче шести символов!';
            }
            
            //Проверяем - существует ли пользователь с введенным логином и паролем в нашей БД?
            $userId = User::checkUserData($email, $password);
            
            
            if ($userId == false) {
                //Если введенные данные неправильные (не нашли соотв пользователя) - показываем ошибку
                $errors[] = 'Неправильные данные для входа на сайт';
            }
            else {
                //если данные правильные - запоминаем их - т.е. создаем сессию
                User::auth($userId);
                
                //Перенаправляем true-пользователя в закрытую часть сайта - кабинет
                header("Location: /cabinet/");
                
            }
            
        }
        
        
        //User registration page
        require_once(ROOT . '/views/user/login.php');
        
        return true;
        
    }
    
    public function actionLogout() {
        session_start();
        unset($_SESSION['user']);
        header("Location: /");
    }
    
}