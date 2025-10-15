<?php include '../view/header.php'; ?>

<main>
    <h1>Product List</h1>

    <?php if (count($products) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Version</th>
                    <th>Release Date</th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['productCode']); ?></td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td><?php echo htmlspecialchars($product['version']); ?></td>
                    <td><?php echo htmlspecialchars($product['releaseDate']); ?></td>
                    <td>
                        <form method="post" action=".">
                            <input type="hidden" name="action" value="delete_product">
                            <input type="hidden" name="productCode" value="<?php echo htmlspecialchars($product['productCode']); ?>">
                            <button type="submit" onclick="return confirm('Delete this product?')">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No products found.</p>
    <?php endif; ?>

    <p>
        <a href=".?action=show_add_form">Add Product</a>
    </p>
</main>

<?php include '../view/footer.php'; ?>
