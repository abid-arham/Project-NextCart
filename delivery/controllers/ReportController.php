<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'delivery_manager') {
    header("Location: /nextcart/controllers/LoginController.php");
    exit;
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/DeliveryModel.php';

$model = new DeliveryModel($conn);

$agent_report = $model->getAgentReport();
$zone_report  = $model->getZoneReport();
$daily        = $model->getDailySummary();

require_once __DIR__ . '/../views/delivery_manager/reports.php';
?>