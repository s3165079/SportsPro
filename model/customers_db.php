<?php

function get_customers_by_last_name($lastName){
    global $db;

    // query the customer's information
    $query = 'SELECT customerID, firstName, lastName, email, city
				  FROM customers
				  WHERE lastName LIKE :lastName
				  ORDER BY lastName, firstName';

    $statement = $db->prepare($query);
    $statement->bindValue(':lastName', '%' . $lastName . '%');	//should allow for partial matches
    $statement->execute();
    $customers = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    return $customers;
}

function get_customer_by_id($customerID){
    global $db;

    $query = 'SELECT customerID, firstName, lastName, address, city, state,
                         postalCode, countryCode, phone, email, password
                  FROM customers
                  WHERE customerID = :customer_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':customer_id', $customerID, PDO::PARAM_INT);
    $statement->execute();
    $customer = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    return $customer;
}

function get_customer_by_email($email){
    global $db;

    $query = 'SELECT customerID, firstName, lastName, address, city, state,
                         postalCode, countryCode, phone, email, password
                  FROM customers
                  WHERE email = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $customer = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    return $customer;
}

function get_registration($customerID, $productCode) {
    global $db;

    $query = 'SELECT * FROM registrations
              WHERE customerID = :customerID
              AND productCode = :productCode';
    $statement = $db->prepare($query);
    $statement->bindValue(':customerID', $customerID);
    $statement->bindValue(':productCode', $productCode);
    $statement->execute();
    $registration = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    return $registration;
}

function add_registration($customerID, $productCode) {
    global $db;

    $query = 'INSERT INTO registrations (customerID, productCode, registrationDate)
              VALUES (:customerID, :productCode, NOW())';
    $statement = $db->prepare($query);
    $statement->bindValue(':customerID', $customerID);
    $statement->bindValue(':productCode', $productCode);
    $statement->execute();
    $statement->closeCursor();
}

function update_customer(array $cusUpdates): void {
    global $db;

    $query = 'UPDATE customers
              SET firstName = :firstName,
                  lastName = :lastName,
                  address = :address,
                  city = :city,
                  state = :state,
                  postalCode = :postalCode,
                  countryCode = :countryCode,
                  phone = :phone,
                  email = :email,
                  password = :password
              WHERE customerID = :customerID';

    $statement = $db->prepare($query);
    $statement->bindValue(':firstName', $cusUpdates['firstName']);
    $statement->bindValue(':lastName', $cusUpdates['lastName']);
    $statement->bindValue(':address', $cusUpdates['address']);
    $statement->bindValue(':city', $cusUpdates['city']);
    $statement->bindValue(':state', $cusUpdates['state']);
    $statement->bindValue(':postalCode', $cusUpdates['postalCode']);
    $statement->bindValue(':countryCode', $cusUpdates['countryCode']);
    $statement->bindValue(':phone', $cusUpdates['phone']);
    $statement->bindValue(':email', $cusUpdates['email']);
    $statement->bindValue(':password', $cusUpdates['password']);
    $statement->bindValue(':customerID', $cusUpdates['customerID'], PDO::PARAM_INT);

    $statement->execute();
    $statement->closeCursor();

}

function get_all_countries() {
    global $db;

    $stmt = $db->prepare('SELECT * 
                            FROM countries 
                            ORDER BY countryName ASC');
    $stmt->execute();

    // Fetch all rows as associative arrays
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
