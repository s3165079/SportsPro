<?php include '../view/header.php'; ?>

<main>
    <h1>Technicians List</h1>

    <?php if (count($techs) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Password</th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($techs as $tech): ?>
                <tr>
                    <td><?php echo htmlspecialchars($tech['firstName']); ?></td>
                    <td><?php echo htmlspecialchars($tech['lastName']); ?></td>
                    <td><?php echo htmlspecialchars($tech['email']); ?></td>
                    <td><?php echo htmlspecialchars($tech['phone']); ?></td>
                    <td><?php echo htmlspecialchars($tech['password']); ?></td>
                    <td>
                        <form method="post" action=".">
                            <input type="hidden" name="action" value="delete_tech">
                            <input type="hidden" name="techID" value="<?php echo htmlspecialchars($tech['techID']); ?>">
                            <button type="submit" onclick="return confirm('Delete this Technician')">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No Technicians found.</p>
    <?php endif; ?>

    <p>
        <a href=".?action=add_tech">Add Technicians</a>
    </p>
</main>

<?php include '../view/footer.php'; ?>
