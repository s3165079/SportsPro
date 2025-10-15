<?php
require('../model/database.php');
require('../model/product_db.php');

$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'list_products';
    }
}

// Added switch cases for actions to list/delete products 
// and show the add product form
switch ($action) {
    case 'list_products':
        $products = get_products();
        include('product_list.php');
        break;

    case 'delete_product':
        $productCode = filter_input(INPUT_POST, 'productCode');
        if ($productCode) {
            delete_product($productCode);
        }
        header("Location: .?action=list_products");
        exit();

    case 'show_add_form':
        include('add_product.php');
        break;

    default:
        include('../under_construction.php');
        break;
}
?>