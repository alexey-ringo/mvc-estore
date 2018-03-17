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
    
}