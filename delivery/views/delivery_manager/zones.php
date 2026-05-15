<!DOCTYPE html>
<html>
<head>
    <title>Manage Zones</title>
</head>
<body>

<h2>Delivery Zones</h2>
<a href="/nextcart/controllers/DashboardController.php">Back to Dashboard</a>

<?php if ($success): ?>
    <p style="color:green">Zone added successfully.</p>
<?php endif; ?>

<h3>Add New Zone</h3>
<form method="POST" action="/nextcart/controllers/ZoneController.php">
    <input type="text" name="zone_name" placeholder="Zone Name" required><br><br>
    <input type="number" step="0.01" name="delivery_fee" placeholder="Delivery Fee" required><br><br>
    <input type="number" name="estimated_days" placeholder="Estimated Days" required><br><br>
    <button type="submit" name="add_zone">Add Zone</button>
</form>

<h3>All Zones</h3>
<table border="1" cellpadding="8">
    <tr>
        <th>Zone</th>
        <th>Fee</th>
        <th>Estimated Days</th>
        <th>Action</th>
    </tr>
    <?php foreach ($zones as $z): ?>
    <tr>
        <td><?php echo htmlspecialchars($z['zone_name']); ?></td>
        <td>৳<?php echo $z['delivery_fee']; ?></td>
        <td><?php echo $z['estimated_days']; ?> days</td>
        <td>
            <a href="/nextcart/controllers/ZoneController.php?delete=<?php echo $z['id']; ?>"
               onclick="return confirm('Delete this zone?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>