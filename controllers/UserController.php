<?php

class UserController {
    
    public function actionRegister() {
        
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            
            
        }
        
        
        //User registration page
        require_once(ROOT . '/views/user/register.php');
        
        return true;
    }
    
}