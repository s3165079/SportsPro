<?php 
require('../model/database.php');
require_once('../model/customers_db.php');

// Get customer information
$customer_id = filter_input(INPUT_GET, 'customerID', FILTER_VALIDATE_INT);

// Check to see if customer's last name exists
$customers = [];
$lastName = filter_input(INPUT_GET, 'lastName', FILTER_SANITIZE_STRING);
if (isset($_GET['lastName']) && !empty($_GET['lastName'])) {
	$lastName = $_GET['lastName'];
	
	// exceptions
	try {
        $customers = get_customers_by_last_name($lastName);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../errors/database_error.php');
        exit();
    }
}
?>

<?php include '../view/header.php'; ?>

<main>
	<h1>Customer Search</h1>
	
	<!-- Search for customer -->
    <form method="get" action="index.php">
        <input type="hidden" name="action" value="search_customers">
        <label for="lastName">Last Name:</label>
        <input id="lastName" type="search" name="lastName" placeholder="Search..."
               value="<?php echo htmlspecialchars($lastName ?? ''); ?>">
        <button type="submit">Search</button>
    </form>
	
	<!-- Display the Results; if/else customers are found or not -->
	<h2>Results</h2>
	<?php if (!empty($customers)): ?>
		<table>
			<thead>
				<tr>
					<th>Name</th>
					<th>Email Address</th>
					<th>City</th>
					<th> </th>
				</tr>
			</thead>
			
			<tbody>
				<?php foreach ($customers as $customer): ?>
					<tr>
						<td><?php echo htmlspecialchars($customer['firstName'] . ' ' . $customer['lastName']); ?></td>
						<td><?php echo htmlspecialchars($customer['email']); ?></td>
						<td><?php echo htmlspecialchars($customer['city']); ?></td>
						<td>
                            <form action="index.php" method="post">
                                <input type="hidden" name="action" value="edit_customer">
                                <input type="hidden" name="customerID" value="<?php echo (int)$customer['customerID']; ?>">
                                <input type="submit" value="Select"/>
                            </form>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<!-- if statement for no name found -->
	<?php else: ?>
		<p>No customers were found with that last name.</p>
	<?php endif; ?>
	
</main>
<?php include '../view/footer.php'; ?>