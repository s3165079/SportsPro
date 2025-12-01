<?php

function get_products() {
    global $db;
   $query = 'SELECT productCode, name, version, DATE_FORMAT(releaseDate, "%M %d %Y") AS formattedDate 
          FROM products 
          ORDER BY name';
    $statement = $db->prepare($query);
    $statement->execute();
    $products = $statement->fetchAll();
    $statement->closeCursor();
    return $products;
}

function delete_product($productCode) {
    global $db;
    $query = 'DELETE FROM products WHERE productCode = :productCode';
    $statement = $db->prepare($query);
    $statement->bindValue(':productCode', $productCode);
    $statement->execute();
    $statement->closeCursor();
}
?>
