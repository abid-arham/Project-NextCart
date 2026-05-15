<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>

<h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></h2>

<div style="display:flex; gap:20px;">
    <div style="background:#f0f0f0; padding:20px; border-radius:10px;">
        <h3>Pending Dispatch</h3>
        <p style="font-size:30px"><?php echo $pending_count; ?></p>
    </div>
    <div style="background:#cce5ff; padding:20px; border-radius:10px;">
        <h3>Active Deliveries</h3>
        <p style="font-size:30px"><?php echo $active_count; ?></p>
    </div>
    <div style="background:#d4edda; padding:20px; border-radius:10px;">
        <h3>Delivered Today</h3>
        <p style="font-size:30px"><?php echo $today_count; ?></p>
    </div>
</div>

<br>
<div id="live-stats" style="background:#fff3cd; padding:15px; border-radius:8px;">
    <strong>Live Stats (updates every 10 seconds):</strong>
    Active: <span id="live-active">...</span> |
    Delivered Today: <span id="live-today">...</span> |
    Pending: <span id="live-pending">...</span>
</div>

<br>
<a href="/nextcart/controllers/AgentController.php">Manage Agents</a> |
<a href="/nextcart/controllers/ZoneController.php">Manage Zones</a> |
<a href="/nextcart/controllers/DispatchController.php">Dispatch Orders</a> |
<a href="/nextcart/controllers/ActiveDeliveryController.php">Active Deliveries</a> |
<a href="/nextcart/controllers/HistoryController.php">Delivery History</a> |
<a href="/nextcart/controllers/ReportController.php">Reports</a> |
<a href="/nextcart/logout.php">Logout</a>

<script>
function loadLiveStats() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/nextcart/api/delivery_status.php', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);
            document.getElementById('live-active').textContent  = data.active;
            document.getElementById('live-today').textContent   = data.delivered_today;
            document.getElementById('live-pending').textContent = data.pending_dispatch;
        }
    };
    xhr.send();
}

loadLiveStats();
setInterval(loadLiveStats, 10000);
</script>

</body>
</html>