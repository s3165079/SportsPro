<?php
// add_product.php
require('database.php'); // Include database connection

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $code = trim($_POST['code'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $version = trim($_POST['version'] ?? '');
    $release_date = trim($_POST['release_date'] ?? '');

    // Validate input fields
    if (empty($code) || empty($name) || empty($version) || empty($release_date)) {
        // If any field is missing, redirect to the error page with a message
        header('Location: error.php?error=Missing+required+fields');
        exit();
    }

    // SQL query to insert the product data into the database
    $query = 'INSERT INTO products (productCode, name, version, releaseDate)
              VALUES (:code, :name, :version, :release_date)';
    $statement = $db->prepare($query);
    $statement->bindValue(':code', $code);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':version', $version);
    $statement->bindValue(':release_date', $release_date);
    $statement->execute();
    $statement->closeCursor();

    // After adding, redirect to the product list page
    header('Location: product_list.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
</head>
<body>
    <h1>Add New Product</h1>
    <form action="add_product.php" method="POST">
        <label for="code">Product Code:</label>
        <input type="text" id="code" name="code" required><br><br>

        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="version">Product Version:</label>
        <input type="text" id="version" name="version" required><br><br>

        <label for="release_date">Release Date:</label>
        <input type="date" id="release_date" name="release_date" required><br><br>

        <input type="submit" value="Add Product">
    </form>

    <br>
    <a href="product_list.php">View Product List</a> |
    <a href="index.php">Home</a>
</body>
</html>
