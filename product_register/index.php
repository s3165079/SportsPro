<?php

session_set_cookie_params(0, '/');
session_start();

require('../model/database.php');
require('../model/customers_db.php');
require('../model/product_db.php');

$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        // If customer is logged in, go to register product WM 12/6/25
        if (isset($_SESSION['customer'])){
            $customer = $_SESSION['customer'];
            $products = get_products();
            include('product_register.php');
            exit();
        } else {
            $action = 'login_customer';
        }
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

    // store customer data in session WM 12/6/25
    $_SESSION['customer'] = $customer;
    
    $products = get_products();
    include('product_register.php');
    
} else if ($action == 'register_product') {

    // get the customer from session, send back to login if not logged in WM 12/6/25
    if(!isset($_SESSION['customer'])){
        $email = '';
        include('customer_login.php');
        exit();
    }

    $customer = $_SESSION['customer'];
    $customer_id = $customer['customerID'];
    $product_code = filter_input(INPUT_POST, 'product_code');
    
    // only add if not already registered
    $registration = get_registration($customer_id, $product_code);

    if (!$registration) {
        add_registration($customer_id, $product_code);
        header("Location: .?action=success&product_code=$product_code");
    } else {
        $error = "Product ($product_code) is already registered. Please try again.";
        include('../errors/error.php');
    }
} else if ($action == 'logout') {
    $_SESSION = [];
    session_destroy();
    header("Location: .?action=login_customer");
    exit();
} else if ($action == 'success') {
    $product_code = filter_input(INPUT_GET, 'product_code');
    $message = "Product ($product_code) was registered successfully.";
    include('product_register.php');
}
?>