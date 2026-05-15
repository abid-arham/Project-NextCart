<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'delivery_manager') {
    header("Location: /nextcart/controllers/LoginController.php");
    exit;
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/DeliveryModel.php';

$model = new DeliveryModel($conn);
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $assign_id   = (int)$_POST['assign_id'];
    $new_status  = $_POST['new_status'];
    $fail_reason = $_POST['fail_reason'] ?? '';
    $model->updateStatus($assign_id, $new_status, $fail_reason);
    $success = true;
}

$deliveries = $model->getActiveDeliveries();

require_once __DIR__ . '/../views/delivery_manager/active_deliveries.php';
?>