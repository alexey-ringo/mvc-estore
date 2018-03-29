<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Router {
    //Свойство для хранения маршрутов
    private $routes;
    
    //В конструкторе мы читаем и запоминаем маршруты
    public function __construct() {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }
    
    private function getURI() {
        if(!empty($_SERVER['REQUEST_URI'])):
            return trim($_SERVER['REQUEST_URI'], '/');
        endif;
    }
    
    public function run() {
        /*
        echo 'Массив маршрутов: ';
        print_r($this->routes);
        */
        
        
        //Получить строку запроса, отправленного пользователем
        $uri = $this->getURI();
        //echo $uri;
        
        //Для моей среды netBeans в строке запроса нужно вырезать лишнее mvc-estore
        $uriCloud9CutStr = 'mvc-estore';
        $uriCloudCutPattern = '';
        if(preg_match("~$uriCloud9CutStr~", $uri)) {
            $uri = preg_replace('#mvc-estore#', '', $uri);
        }
        
        //Проверить наличие полученного запроса в router.php
        
        //Вывести наличие всех предустановленных запросов из routes.php
        foreach($this->routes as $uriPattern => $path) {
            //Для каждого маршрута в $uriPattern помещаем строку запроса из routes.php
            //Для каждого маршрута в $path помещаем строку предустановленного пути (к контроллеру и action) из routes.php
            //echo '<br>' . $uriPattern . ' -> ' . $path;
            
            
            //Находим совпадение $uriPattern-шаблона запроса из routes.php и $uri-реального запроса пользователя
            //Если есть совпадение, определить - какой контроллер,
            //и action будут обрабатывать запрос
            if(preg_match("~$uriPattern~", $uri)) {
                
                //echo '<br>Где ищем (Запрос, который набрал пользователь): ' . $uri;
                //echo '<br>Что ищем(совпадение из правила): ' . $uriPattern;
                //echo '<br>Кто обрабатывает: ' . $path;
                
                
                //Получаем внутренний путь из внешнего согласно правилу
                $internalRouter = preg_replace("~$uriPattern~", $path, $uri);
                
                
                //разделяем маршрут на массив из 4-х элементов (сегментирование),
                //и заносим в массив отдельными элементами.
                //Разделение на элементы - по слэшу
                $segments = explode('/', $internalRouter);
                
                //Формируем имя контроллера. Функция array_shift получает первый элемент из массива,
                //и затем удаляет его из массива.
                //Дополнительно добавим к имени слово Контроллер - как положено по регламенту MVC
                $controllerName = array_shift($segments) . 'Controller';
                
                //Дополнительно изменим первую букву имени контроллера на заглавную
                $controllerName = ucfirst($controllerName);
                
                /*
                echo $controllerName;
                NewsController
                ProductController
                */
                
                //Формируем имя action. Функция array_shift берет второй, оставшийся элемент массива
                //ucfirst - первая буква заглавная
                $actionName = 'action' . ucfirst(array_shift($segments));
                
                //Проверка:
                //echo '<br>Класс: ' . $controllerName;
                //echo '<br>Метод: ' . $actionName;
                /*
                при запросе пользователя news/view/sport/114 - Выводит:
                        Класс: NewsController
                        Метод: actionView
                */
                
                //После извлечения (и удаления) из массива элементов с названием контроллера и action,
                //в массиве остались только параметры, которые понадобятся для идентифицирвоания конкретной статьи
                $parametrs = $segments;
                
                //echo '<pre>';
                //print_r($parametrs);
                //echo '</pre>';
                /*
                Выводит оставшиеся элементы в масссиве (при исходном пользовательском запросе news/view/sport/114): 
                    Array
                    (
                        [0] => sport
                        [1] => 114
                    )
                
                При вводе в запрос новых дополнительных полей - news/sport/114/addparam3/addparam4
                все они так же записываются в массив и могут потом быть переданы соотв action
                    Array
                    (
                        [0] => sport
                        [1] => 114
                        [2] => addparam3
                        [3] => addparam4
                    )
                */
                
                
                //Подключить файл нужного класса-контроллера
                
                //В переменную записываем путь к файлу нужного Контроллера
                $controllerFile = ROOT . '/controllers/' .
                    $controllerName . '.php';
                
                //Если такой файл существует - подключаем его
                if(file_exists($controllerFile)) {
                    include_once($controllerFile);
                }
                
                
                
                
                //Создать объект нужного класса-Контроллера и вызвать метод (т.е. - action)
                //Имена класса-контроллера и метода - в переменных
                $controllerObject = new $controllerName;
                
                //Вариант передачи в action чистого массива с параметрами статьи
                //$result = $controllerObject->$actionName($parametrs);
                
                /* Вызываем необходимый метод ($actionName) у определенного 
                 класса ($controllerObject) с заданными ($parameters) параметрами
                 */
                $result = call_user_func_array(array($controllerObject, $actionName), $parametrs);
                
                // Если метод контроллера успешно вызван, завершаем работу роутера
                if($result != null) {
                    break;
                }
            }
            
            /* ТОЛЬКО НА ВРЕМЯ РАЗРАБОТКИ!!!!!!!!!!!!!!!!!!!! */
            /*
            else {
                echo 'нет совпадения!';
            }
            */
        }
        
    
    }
}

