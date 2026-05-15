<!DOCTYPE html>
<html>
<head>
    <title>Reports</title>
</head>
<body>

<h2>Delivery Reports</h2>
<a href="/nextcart/controllers/DashboardController.php">Back to Dashboard</a>

<h3>Agent Performance</h3>
<table border="1" cellpadding="8">
    <tr>
        <th>Agent</th>
        <th>Total</th>
        <th>Delivered</th>
        <th>Failed</th>
        <th>Success Rate</th>
    </tr>
    <?php foreach ($agent_report as $a): ?>
    <tr>
        <td><?php echo htmlspecialchars($a['name']); ?></td>
        <td><?php echo $a['total']; ?></td>
        <td><?php echo $a['delivered']; ?></td>
        <td><?php echo $a['failed']; ?></td>
        <td><?php echo $a['total'] > 0 ? round(($a['delivered'] / $a['total']) * 100) : 0; ?>%</td>
    </tr>
    <?php endforeach; ?>
</table>

<h3>Zone Performance</h3>
<table border="1" cellpadding="8">
    <tr>
        <th>Zone</th>
        <th>Total</th>
        <th>Delivered</th>
        <th>Failed</th>
    </tr>
    <?php foreach ($zone_report as $z): ?>
    <tr>
        <td><?php echo htmlspecialchars($z['delivery_zone']); ?></td>
        <td><?php echo $z['total']; ?></td>
        <td><?php echo $z['delivered']; ?></td>
        <td><?php echo $z['failed']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<h3>Daily Summary (Last 7 Days)</h3>
<table border="1" cellpadding="8">
    <tr>
        <th>Date</th>
        <th>Total</th>
        <th>Delivered</th>
        <th>Failed</th>
        <th>In Transit</th>
    </tr>
    <?php foreach ($daily as $d): ?>
    <tr>
        <td><?php echo $d['date']; ?></td>
        <td><?php echo $d['total']; ?></td>
        <td><?php echo $d['delivered']; ?></td>
        <td><?php echo $d['failed']; ?></td>
        <td><?php echo $d['in_transit']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>