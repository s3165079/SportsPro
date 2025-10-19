<?php
require('../model/database.php');
require_once('../model/customers_db.php');

$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'search_customers';
    }
}

switch ($action) {
    case 'search_customers':
        include('search_customer.php');
        break;

    case 'edit_customer':
        $customer_id = filter_input(INPUT_POST, 'customerID', FILTER_VALIDATE_INT)
            ?? filter_input(INPUT_GET, 'customerID', FILTER_VALIDATE_INT);

        $customer = $customer_id ? (get_customer_by_id($customer_id) ?? []) : [];
        $updated  = filter_input(INPUT_GET, 'updated');
        include('update_customer.php');
        break;

    case 'update_customer':
        // Preserve old values for blanks, then PRG back to edit
        $customer_id = filter_input(INPUT_POST, 'customerID', FILTER_VALIDATE_INT);
        if (!$customer_id) {
            header('Location: index.php?action=search_customers');
            exit();
        }

        $current = get_customer_by_id($customer_id) ?? [];

        $cusUpdates = [
            'customerID'  => $customer_id,
            'firstName'   => $_POST['firstName']   !== '' ? $_POST['firstName']   : ($current['firstName']   ?? ''),
            'lastName'    => $_POST['lastName']    !== '' ? $_POST['lastName']    : ($current['lastName']    ?? ''),
            'address'     => $_POST['address']     !== '' ? $_POST['address']     : ($current['address']     ?? ''),
            'city'        => $_POST['city']        !== '' ? $_POST['city']        : ($current['city']        ?? ''),
            'state'       => $_POST['state']       !== '' ? $_POST['state']       : ($current['state']       ?? ''),
            'postalCode'  => $_POST['postalCode']  !== '' ? $_POST['postalCode']  : ($current['postalCode']  ?? ''),
            'countryCode' => $_POST['countryCode'] !== '' ? $_POST['countryCode'] : ($current['countryCode'] ?? ''),
            'phone'       => $_POST['phone']       !== '' ? $_POST['phone']       : ($current['phone']       ?? ''),
            'email'       => $_POST['email']       !== '' ? $_POST['email']       : ($current['email']       ?? ''),
            'password'    => $_POST['password']    !== '' ? $_POST['password']    : ($current['password']    ?? ''),
        ];

        try {
            update_customer($cusUpdates);
            $updateStatus = true;
        } catch (PDOException $e) {
            $updateStatus = false;
        }

        header('Location: index.php?action=edit_customer&customerID='
            . urlencode((string)$customer_id) . '&updated=' . (int)$updateStatus);

        exit();

    default:
        include('../under_construction.php');
        break;
}
?>
