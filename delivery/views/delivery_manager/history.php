<!DOCTYPE html>
<html>
<head>
    <title>Delivery History</title>
</head>
<body>

<h2>Delivery History</h2>
<a href="/nextcart/controllers/DashboardController.php">Back to Dashboard</a>

<table border="1" cellpadding="8">
    <tr>
        <th>Order</th>
        <th>Agent</th>
        <th>Zone</th>
        <th>Status</th>
        <th>Date</th>
        <th>Fail Reason</th>
    </tr>
    <?php foreach ($history as $h): ?>
    <tr>
        <td>#<?php echo $h['order_id']; ?></td>
        <td><?php echo htmlspecialchars($h['agent_name']); ?></td>
        <td><?php echo htmlspecialchars($h['delivery_zone']); ?></td>
        <td><?php echo $h['status']; ?></td>
        <td><?php echo $h['assigned_at']; ?></td>
        <td><?php echo htmlspecialchars($h['fail_reason'] ?? '-'); ?></td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>