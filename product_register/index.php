<?php
require('../model/database.php');
require('../model/customers_db.php');
require('../model/product_db.php');

$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'login_customer';
    }
}

//instantiate variable(s)
$email = '';

if ($action == 'login_customer') {
    include('customer_login.php');
} else if ($action == 'get_customer') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if (empty($email) || $email === FALSE) {
        $error = "Invalid email. Please try again.";
        include('../errors/error.php');
        exit();
    } 
    
    $customer = get_customer_by_email($email);
    if ($customer === NULL) {
        $error = "Customer doesn't exist. Please try again.";
        include('../errors/error.php');
        exit();
    }
    
    $products = get_products();
    include('product_register.php');
    
} else if ($action == 'register_product') {
    $customer_id = filter_input(INPUT_POST, 'customer_id', FILTER_VALIDATE_INT);
    $product_code = filter_input(INPUT_POST, 'product_code');
    
    // only add if not already registered
    $registration = get_registration($customer_id, $product_code);
    if ($registration === NULL) {
        add_registration($customer_id, $product_code);
        header("Location: .?action=success&product_code=$product_code");
    } else {
        $error = "Product ($product_code) is already registered. Please try again.";
        include('../errors/error.php');
    }
} else if ($action == 'success') {
    $product_code = filter_input(INPUT_GET, 'product_code');
    $message = "Product ($product_code) was registered successfully.";
    include('product_register.php');
}
?>