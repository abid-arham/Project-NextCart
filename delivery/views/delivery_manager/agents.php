<!DOCTYPE html>
<html>
<head>
    <title>Manage Agents</title>
</head>
<body>

<h2>Delivery Agents</h2>
<a href="/nextcart/controllers/DashboardController.php">Back to Dashboard</a>

<?php if ($success): ?>
    <p style="color:green">Agent added successfully.</p>
<?php endif; ?>

<h3>Add New Agent</h3>
<form method="POST" action="/nextcart/controllers/AgentController.php">
    <input type="text" name="name" placeholder="Agent Name" required><br><br>
    <input type="text" name="phone" placeholder="Phone" required><br><br>
    <select name="vehicle_type">
        <option value="bike">Bike</option>
        <option value="car">Car</option>
        <option value="van">Van</option>
    </select><br><br>
    <button type="submit" name="add_agent">Add Agent</button>
</form>

<h3>All Agents</h3>
<table border="1" cellpadding="8">
    <tr>
        <th>Name</th>
        <th>Phone</th>
        <th>Vehicle</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php foreach ($agents as $a): ?>
    <tr>
        <td><?php echo htmlspecialchars($a['name']); ?></td>
        <td><?php echo htmlspecialchars($a['phone']); ?></td>
        <td><?php echo htmlspecialchars($a['vehicle_type']); ?></td>
        <td><?php echo $a['is_active'] ? 'Active' : 'Inactive'; ?></td>
        <td>
            <a href="/nextcart/controllers/AgentController.php?toggle=<?php echo $a['id']; ?>">
                <?php echo $a['is_active'] ? 'Deactivate' : 'Activate'; ?>
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>