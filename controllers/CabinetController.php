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
        echo $userId;
        
        require_once(ROOT . '/views/cabinet/index.php');
        return true;
    }
    
}