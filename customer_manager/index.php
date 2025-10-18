<?php 
require('../model/database.php');
require('../model/product_db.php');

// Get customer information
$customer_id = filter_input(INPUT_GET, 'customerID', FILTER_VALIDATE_INT);

// Check to see if customer's last name exists
$customers = [];
if (isset($_GET['lastName']) && !empty($_GET['lastName'])) {
	$lastName = $_GET['lastName'];
	
	// exceptions
	try {
        $db = new PDO($dsn, $username, $password);
		
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
	<form method="get" action=".">
		<label for="lastName">Last Name:</label>
		<input type="Search" name="lastName" placeholder="Search...">
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
							<form action="../view/view_update_customer.php" method="post">
								<input type="hidden" name="customerID" value="."> <!-- Decided to not pass customerID through value, it caused a FatalError code -->
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