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

