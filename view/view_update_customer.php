<?php
require_once('database.php');

// Get the customer ID from the query string
$customer_id = filter_input(INPUT_GET, 'customerID', FILTER_VALIDATE_INT);

// Handle form submission 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = filter_input(INPUT_POST, 'customerID', FILTER_VALIDATE_INT);
    $firstName = filter_input(INPUT_POST, 'firstName');
    $lastName = filter_input(INPUT_POST, 'lastName');
    $address = filter_input(INPUT_POST, 'address');
    $city = filter_input(INPUT_POST, 'city');
    $state = filter_input(INPUT_POST, 'state');
    $postalCode = filter_input(INPUT_POST, 'postalCode');
    $countryCode = filter_input(INPUT_POST, 'countryCode');
    $phone = filter_input(INPUT_POST, 'phone');
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');

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
    $statement->bindValue(':firstName', $firstName);
    $statement->bindValue(':lastName', $lastName);
    $statement->bindValue(':address', $address);
    $statement->bindValue(':city', $city);
    $statement->bindValue(':state', $state);
    $statement->bindValue(':postalCode', $postalCode);
    $statement->bindValue(':countryCode', $countryCode);
    $statement->bindValue(':phone', $phone);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $password);
    $statement->bindValue(':customerID', $customer_id);
    $statement->execute();
    $statement->closeCursor();
}

// Get customer info
$query = 'SELECT * FROM customers WHERE customerID = :customer_id';
$statement = $db->prepare($query);
$statement->bindValue(':customer_id', $customer_id);
$statement->execute();
$customer = $statement->fetch();
$statement->closeCursor();
?>

<?php include('view/header.php'); ?>

<main>
    <h2>View/Update Customer</h2>

    <form action="view_update_customer.php" method="post">
        <input type="hidden" name="customerID" value="<?php echo $customer['customerID']; ?>">

        <label>First Name:</label>
        <input type="text" name="firstName" value="<?php echo htmlspecialchars($customer['firstName']); ?>"><br>

        <label>Last Name:</label>
        <input type="text" name="lastName" value="<?php echo htmlspecialchars($customer['lastName']); ?>"><br>

        <label>Address:</label>
        <input type="text" name="address" value="<?php echo htmlspecialchars($customer['address']); ?>"><br>

        <label>City:</label>
        <input type="text" name="city" value="<?php echo htmlspecialchars($customer['city']); ?>"><br>

        <label>State:</label>
        <input type="text" name="state" value="<?php echo htmlspecialchars($customer['state']); ?>"><br>

        <label>Postal Code:</label>
        <input type="text" name="postalCode" value="<?php echo htmlspecialchars($customer['postalCode']); ?>"><br>

        <label>Country Code:</label>
        <input type="text" name="countryCode" value="<?php echo htmlspecialchars($customer['countryCode']); ?>"><br>

        <label>Phone:</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($customer['phone']); ?>"><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>"><br>

        <label>Password:</label>
        <input type="text" name="password" value="<?php echo htmlspecialchars($customer['password']); ?>"><br>

        <input type="submit" value="Update Customer">
    </form>
</main>

<?php include('view/footer.php'); ?>
