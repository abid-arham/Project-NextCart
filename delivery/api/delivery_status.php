<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'delivery_manager') {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/DeliveryModel.php';

$model = new DeliveryModel($conn);

echo json_encode([
    'active'          => $model->getActiveDeliveryCount(),
    'delivered_today' => $model->getDeliveredTodayCount(),
    'pending_dispatch'=> $model->getPendingDispatchCount()
]);
?>