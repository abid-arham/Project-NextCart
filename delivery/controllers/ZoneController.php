<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'delivery_manager') {
    header("Location: /nextcart/controllers/LoginController.php");
    exit;
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/ZoneModel.php';

$model = new ZoneModel($conn);
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_zone'])) {
    $model->addZone($_POST['zone_name'], $_POST['delivery_fee'], $_POST['estimated_days']);
    $success = true;
}

if (isset($_GET['delete'])) {
    $model->deleteZone((int)$_GET['delete']);
    header("Location: /nextcart/controllers/ZoneController.php");
    exit;
}

$zones = $model->getAllZones();

require_once __DIR__ . '/../views/delivery_manager/zones.php';
?>