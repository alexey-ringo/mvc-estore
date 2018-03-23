<?php

class CartController {
    
    public function actionAdd($id) {
    //Добавить товар в корзину
    Cart::addProduct($id);
    
    //Вернуть пользователя обратно на страницу
    //Узнаем адрес страницы, с которой пришел пользователь
    $referrer = $_SERVER['HTTP_REFERER'];
    //И перенаправляем его обратно
    header("Location: $referrer");
    }
    
}