<?php
/*
class Category returnes array of categories from DB
*/

class Category {
    
    public static function getCategoriesList() {
        //Получаем объект класса PDO, созданный в статическом методе getConnection() класса Db
        //components/Db.php
		$db = Db::getConnection();
		
		$categoryList = array();
		
		$result = $db->query('SELECT id, name FROM category '
		          . 'ORDER BY sort_order ASC' );    
		
		$i = 0;
		while($row = $result->fetch()) {
		    $categoryList[$i]['id'] = $row['id'];
		    $categoryList[$i]['name'] = $row['name'];
		    $i++;
		}
        
        return $categoryList;
    }
    
}