<?php
require('../model/database.php');
require_once('../model/customers_db.php');

// Get the customer ID from the query string
$customer_id = filter_input(INPUT_POST, 'customerID', FILTER_VALIDATE_INT)
        ?: filter_input(INPUT_GET, 'customerID', FILTER_VALIDATE_INT);

//array to hold customer data
$customer = get_customer_by_id($customer_id);

?>

<?php include('../view/header.php'); ?>

<main>
    <h2>View/Update Customer</h2>

    <?php
        if (isset($_GET['updated'])) {
            if ($_GET['updated'] == '1') {
                echo "<h3>Customer record updated successfully.</h3>";
            } else {
                echo "<h3>Update failed.</h3>";
            }
        }
    ?>

    <form id="aligned" action="index.php" method="post">
        <input type="hidden" name="action" value="update_customer">
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

        <label>Country:</label>
        <?php
        $countries = get_all_countries();
        $selected_country = $customer['countryCode']; 
        ?>
        <select name="countryCode">
            <?php foreach ($countries as $country): ?>
                <option value="<?php echo htmlspecialchars($country['countryCode']); ?>" 
                    <?php echo ($country['countryCode'] === $selected_country) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($country['countryName']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>


        <label>Phone:</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($customer['phone']); ?>"><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>"><br>

        <label>Password:</label>
        <input type="text" name="password" value="<?php echo htmlspecialchars($customer['password']); ?>"><br>

        <input type="submit" name="update_customer" value="Update Customer">
    </form>

    <a href="index.php?action=search_customers">Search Customer</a> |
    <a href="index.php">Home</a>
</main>

<?php include('../view/footer.php'); ?>
