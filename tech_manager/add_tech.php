A<?php
// add_tech.php
// Based on add_product.php, adapted for technicians
include '../view/header.php';

require('../model/database.php');  // Include database connection

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['firstName'] ?? '');
    $lastName  = trim($_POST['lastName'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $phone     = trim($_POST['phone'] ?? '');
    $password  = trim($_POST['password'] ?? '');

    // Validate input fields
    if (empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($password)) {
        header('Location: error.php?error=Missing+required+fields');
        exit();
    }

    // SQL query to insert the technician data into the database
    $query = 'INSERT INTO technicians (firstName, lastName, email, phone, password)
              VALUES (:firstName, :lastName, :email, :phone, :password)';
    $statement = $db->prepare($query);
    $statement->bindValue(':firstName', $firstName);
    $statement->bindValue(':lastName', $lastName);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':phone', $phone);
    $statement->bindValue(':password', $password);

    try {
        $statement->execute();
        $statement->closeCursor();
        // Redirect to technician list with success message
        header('Location: index.php?action=tech_list&success=Technician+Added+Successfully');
        exit();
    } catch (PDOException $e) {
        // Debugging output
        echo 'Error: ' . $e->getMessage();
        include('../errors/database_error.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Technician</title>
    <link rel="stylesheet" href="../view/style.css">  <!-- Main styles -->
    <link rel="stylesheet" href="../view/add_tech.css"> <!-- Specific styles for this page -->
</head>
<body>
<h1>Add New Technician</h1>

<!-- Display success or error message based on query string -->
<?php
if (isset($_GET['error'])) {
    echo '<p style="color:red;">Error: ' . htmlspecialchars($_GET['error']) . '</p>';
}
if (isset($_GET['success'])) {
    echo '<p style="color:green;">' . htmlspecialchars($_GET['success']) . '</p>';
}
?>

<form action="add_tech.php" method="POST">
    <label for="firstName">First Name:</label>
    <input type="text" id="firstName" name="firstName" required><br><br>

    <label for="lastName">Last Name:</label>
    <input type="text" id="lastName" name="lastName" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="phone">Phone:</label>
    <input type="text" id="phone" name="phone" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <input type="submit" value="Add Technician">
</form>

<br>
<a href="index.php">View Technician List</a> |
<a href="/SportsPro/index.php">Home</a>
</body>
<?php include '../view/footer.php'; ?>
</html>
