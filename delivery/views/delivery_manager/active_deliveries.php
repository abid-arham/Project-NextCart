<!DOCTYPE html>
<html>
<head>
    <title>Active Deliveries</title>
</head>
<body>

<h2>Active Deliveries</h2>
<a href="/nextcart/controllers/DashboardController.php">Back to Dashboard</a>

<?php if ($success): ?>
    <p style="color:green">Status updated successfully.</p>
<?php endif; ?>

<table border="1" cellpadding="8">
    <tr>
        <th>Order</th>
        <th>Agent</th>
        <th>Zone</th>
        <th>Current Status</th>
        <th>Assigned At</th>
        <th>Update Status</th>
    </tr>
    <?php foreach ($deliveries as $d): ?>
    <tr>
        <td>#<?php echo $d['order_id']; ?></td>
        <td><?php echo htmlspecialchars($d['agent_name']); ?></td>
        <td><?php echo htmlspecialchars($d['delivery_zone']); ?></td>
        <td><?php echo $d['status']; ?></td>
        <td><?php echo $d['assigned_at']; ?></td>
        <td>
            <form method="POST" action="/nextcart/controllers/ActiveDeliveryController.php">
                <input type="hidden" name="assign_id" value="<?php echo $d['id']; ?>">
                <select name="new_status">
                    <option value="picked_up">Picked Up</option>
                    <option value="in_transit">In Transit</option>
                    <option value="delivered">Delivered</option>
                    <option value="failed">Failed</option>
                </select>
                <input type="text" name="fail_reason" placeholder="Reason if failed">
                <button type="submit" name="update_status">Update</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>