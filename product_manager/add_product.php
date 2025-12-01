<?php
// add_product.php
// D.Locke: added header for continuity between pages
include '../view/header.php';

require('../model/database.php');  // Include database connection

// Enable error reporting for debugging (make sure this is removed in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['code'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $version = trim($_POST['version'] ?? '');
    $release_date = trim($_POST['release_date'] ?? '');

    // Validate input fields
    if (empty($code) || empty($name) || empty($version) || empty($release_date)) {
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

    try {
        $statement->execute();
        $statement->closeCursor();
        // Redirect to product list with success message
        // D.Locke: Updated location to redirect to index.php
        header('Location: index.php?action=list_products&success=Product+Added+Successfully');
        exit();
    } catch (PDOException $e) {
        // Debugging output
        echo 'Error: ' . $e->getMessage();  // Show the error message for debugging
        // Redirect to custom error page
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
        <title>Add Product</title>
        <link rel="stylesheet" href="../view/style.css">  <!-- Main styles from view folder -->
        <link rel="stylesheet" href="../view/add_product.css">  <!-- Specific styles for this page -->
    </head>
    <body>
        <main>
            <h1>Add New Product</h1>

            <!-- Display success or error message based on query string -->
            <?php
            if (isset($_GET['error'])) {
                echo '<p style="color:red;">Error: ' . htmlspecialchars($_GET['error']) . '</p>';
            }
            if (isset($_GET['success'])) {
                echo '<p style="color:green;">' . htmlspecialchars($_GET['success']) . '</p>';
            }
            ?>

            <form id="aligned" action="add_product.php" method="POST">
                <label for="code">Product Code:</label>
                <input type="text" id="code" name="code" required><br>

                <label for="name">Product Name:</label>
                <input type="text" id="name" name="name" required><br>

                <label for="version">Product Version:</label>
                <input type="text" id="version" name="version" required><br>

                <label for="release_date">Release Date:</label>
                <input type="date" id="release_date" name="release_date" required><br>

                <input type="submit" value="Add Product">
            </form>

            <br>
            <!-- D.Locke: changed href to redirect to index.php and included footer for continuity -->
            <a href="index.php">View Product List</a> |
            <a href="/SportsPro/index.php">Home</a>
        </main>
    </body>
    <?php include '../view/footer.php'; ?>
</html>
