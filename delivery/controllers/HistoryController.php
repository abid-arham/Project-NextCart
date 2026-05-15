<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'delivery_manager') {
    header("Location: /nextcart/controllers/LoginController.php");
    exit;
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/DeliveryModel.php';

$model = new DeliveryModel($conn);

$history = $model->getDeliveryHistory();

require_once __DIR__ . '/../views/delivery_manager/history.php';
?>