<?php
/*
class Product returnes array of products from DB
This model works with tablename - product
*/

class Product {
    
    const SHOW_BY_DEFAULT = 10;
    
    /*This method returnes array with latest products
    $count - amount of products witch we want to receive
    */
    /**
     * Возвращает массив последних товаров
     * @param type $count [optional] <p>Количество</p>
     * @param type $page [optional] <p>Номер текущей страницы</p>
     * @return array <p>Массив с товарами</p>
     */
    public static function getLatestProducts($count = self::SHOW_BY_DEFAULT) {
        $count = intval($count);
        
        $db = Db::getConnection();
        
        $productsList = array();
        
        
        $result = $db->query('SELECT id, name, price, image, is_new FROM product '
		          . 'WHERE status = "1"'
		          . 'ORDER BY id DESC '
		          . 'LIMIT ' . $count);
		
		
		$i = 0;
		while($row = $result->fetch()) {
		    $productsList[$i]['id'] = $row['id'];
		    $productsList[$i]['name'] = $row['name'];
		    $productsList[$i]['image'] = $row['image'];
		    $productsList[$i]['price'] = $row['price'];
		    $productsList[$i]['is_new'] = $row['is_new'];
		    $i++;
		}
        
        return $productsList;
    }
    
    
    /*This method returnes array with all products in choose category */
    /**
     * Возвращает список товаров в указанной категории
     * @param type $categoryId <p>id категории</p>
     * @param type $page [optional] <p>Номер страницы</p>
     * @return type <p>Массив с товарами</p>
     */
    public static function getProductsListByCategory($categoryId = false) {
    	if ($categoryId) {
        
        	$db = Db::getConnection();
        
        	$products = array();
        
        
        	$result = $db->query("SELECT id, name, price, image, is_new FROM product "
		        	. "WHERE status = '1' AND category_id = '$categoryId'"
		        	. "ORDER BY id DESC "
		        	. "LIMIT " . self::SHOW_BY_DEFAULT);
		
		
			$i = 0;
			while($row = $result->fetch()) {
		    	$products[$i]['id'] = $row['id'];
		    	$products[$i]['name'] = $row['name'];
		    	$products[$i]['image'] = $row['image'];
		    	$products[$i]['price'] = $row['price'];
		    	$products[$i]['is_new'] = $row['is_new'];
		    	$i++;
			}
		
    	    return $products;
    	}
    }
    
    /**
     * Возвращает продукт с указанным id
     * @param integer $id <p>id товара</p>
     * @return array <p>Массив с информацией о товаре</p>
     */	
    public static function getProductById($id) {
    		
    		$id = intval($id);
    		if ($id) {
        
        		$db = Db::getConnection();
        
        	
        
        
        		$result = $db->query('SELECT * FROM product WHERE id=' . $id);
        		$result->setFetchMode(PDO::FETCH_ASSOC);
		
		
			
    	    	return $result->fetch();
    	    
    		}
    
    	
    }
        
        
    /**
     * Возвращает список товаров с указанными индентификторами
     * @param array $idsArray <p>Массив с идентификаторами</p>
     * @return array <p>Массив со списком товаров</p>
     */
    public static function getProdustsByIds($idsArray) {
    	
        // Соединение с БД
        $db = Db::getConnection();
        // Превращаем массив в строку для формирования условия в запросе
        $idsString = implode(',', $idsArray);
        // Текст запроса к БД
        $sql = "SELECT * FROM product WHERE status='1' AND id IN ($idsString)";
        $result = $db->query($sql);
        // Указываем, что хотим получить данные в виде массива
        $result->setFetchMode(PDO::FETCH_ASSOC);
        // Получение и возврат результатов
        $i = 0;
        $products = array();
        while ($row = $result->fetch()) {
            $products[$i]['id'] = $row['id'];
            $products[$i]['code'] = $row['code'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['price'] = $row['price'];
            $i++;
        }
        return $products;
    }
    
}