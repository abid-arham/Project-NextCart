<!DOCTYPE html>
<html>
<head>
    <title>Dispatch Orders</title>
</head>
<body>

<h2>Dispatch Orders</h2>
<a href="/nextcart/controllers/DashboardController.php">Back to Dashboard</a>

<?php if ($success): ?>
    <p style="color:green">Agent assigned successfully.</p>
<?php endif; ?>

<table border="1" cellpadding="8">
    <tr>
        <th>Order ID</th>
        <th>Address</th>
        <th>Zone</th>
        <th>Amount</th>
        <th>Assign Agent</th>
    </tr>
    <?php foreach ($orders as $o): ?>
    <tr>
        <td>#<?php echo $o['id']; ?></td>
        <td><?php echo htmlspecialchars($o['shipping_address']); ?></td>
        <td><?php echo htmlspecialchars($o['zone_name'] ?? 'N/A'); ?></td>
        <td>৳<?php echo $o['total_amount']; ?></td>
        <td>
            <form method="POST" action="/nextcart/controllers/DispatchController.php">
                <input type="hidden" name="order_id" value="<?php echo $o['id']; ?>">
                <input type="hidden" name="zone_name" value="<?php echo htmlspecialchars($o['zone_name'] ?? ''); ?>">
                <select name="agent_id" required>
                    <option value="">Select Agent</option>
                    <?php foreach ($agents as $a): ?>
                    <option value="<?php echo $a['id']; ?>">
                        <?php echo htmlspecialchars($a['name']); ?> (<?php echo $a['vehicle_type']; ?>)
                    </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="assign">Assign</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>