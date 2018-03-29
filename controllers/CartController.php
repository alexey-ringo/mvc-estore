<?php

class CartController {
    
    /**
     * Action для добавления товара в корзину синхронным запросом<br/>
     * (для примера, не используется)
     * @param integer $id <p>id товара</p>
     */
    public function actionAdd($id) {
    //Добавить товар в корзину
    Cart::addProduct($id);
    
    //Вернуть пользователя обратно на страницу
    //Узнаем адрес страницы, с которой пришел пользователь
    $referrer = $_SERVER['HTTP_REFERER'];
    //И перенаправляем его обратно
    header("Location: $referrer");
    }
    
    /**
     * Action для добавления товара в корзину при помощи асинхронного запроса (ajax)
     * @param integer $id <p>id товара</p>
     */
    public function actionAddAjax($id)
    {
        // Добавляем товар в корзину и печатаем результат: количество товаров в корзине
        echo Cart::addProduct($id);
        return true;
    }
    
    public function actionDelete($id) {
        $delProduct = Cart::deleteProduct($id);
        if($delProduct){
        header("Location: /cart/");
        }
    }
    
    
    /**
     * Action для страницы "Корзина"
     */
    public function actionIndex()
    {
        // Список категорий для левого меню
        $categories = Category::getCategoriesList();
        // Получим идентификаторы и количество товаров в корзине
        $productsInCart = Cart::getProducts();
        if ($productsInCart) {
            // Если в корзине есть товары, получаем полную информацию о товарах для списка
            // Получаем массив только с идентификаторами товаров
            $productsIds = array_keys($productsInCart);
            // Получаем массив с полной информацией о необходимых товарах
            $products = Product::getProdustsByIds($productsIds);
            // Получаем общую стоимость товаров
            $totalPrice = Cart::getTotalPrice($products);
        }
        // Подключаем вид
        require_once(ROOT . '/views/cart/index.php');
        return true;
    }
    
    /**
     * Action для страницы "Оформление покупки"
     */
    public function actionCheckout() {
        //Собираем инф о заказе
        //Получаем список товаров из корзины
        $productsInCart = Cart::getProducts();
            
        //В зависимости от наличия или отсутствия товаров в корзине:
        if($productsInCart == false) {
            //Если в корзине не было товаров - 
            //отправляем пользователя на главную стр. искать товары
            header("Location: /");
        }
        
        // Получаем список категорий для левого меню
        $categories = Category::getCategoriesList();
        
        
        // Находим id всех товаров в корзине
        $productsIds = array_keys($productsInCart);
        $products = Product::getProdustsByIds($productsIds);
        //Суммарная стоимость заказа
        $totalPrice = Cart::getTotalPrice($products);
        // Общее количество товаров, выбранных в корзине
        $totalQuantity = Cart::countItems();
        
        //Первоначально инициализируем поля для формы
        $userName = false;
        $userPhone = false;
        $userComment = false;
        
        // Первоначально инициализируем статус успешности оформления заказа
        $result = false;
        
        // Проверяем является ли пользователь гостем
        if (!User::isGuest()) {
            // Если пользователь не гость
            // Получаем информацию о пользователе из БД
            $userId = User::checkLogged();
            $user = User::getUserById($userId);
            $userName = $user['name'];
        } else {
            // Если гость, поля формы останутся пустыми
            $userId = false;
        }
        
        //Проварка на отправку заказа
        if(isset($_POST['submit'])) {
            //Форма отправлена - да
            //Считываем введенные данные покупателя из полей формы
            $userName = $_POST['userName'];
            $userPhone = $_POST['userPhone'];
            $userComment = $_POST['userComment'];
            
            $errors = false;
            //Валидация считанных пользовательских данных
            if(!User::checkName($userName)) {
                $errors[] = 'Неправильное имя';
            }
            
            if(!User::checkPhone($userPhone)) {
                $errors[] = 'Неправильный телефон';
            }
            
            //Форма заполнена корректно?
            if($errors == false) {
                //Форма заполнена корректно - сохраняем заказ в БД
                //Сохраняем заказ в БД
                $result = Order::save($userName, $userPhone, $userComment, $userId, $productsInCart);
                
                if($result) {
                    //Оповещаем администратора о новом заказе письмом
                    
                    //Очищаем корзину
                    Cart::clear();
                }
                
            }
            
        }
        
        // Подключаем вид
        require_once(ROOT . '/views/cart/checkout.php');
        return true;
    }
     
}