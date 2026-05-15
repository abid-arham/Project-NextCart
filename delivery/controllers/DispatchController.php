<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'delivery_manager') {
    header("Location: /nextcart/controllers/LoginController.php");
    exit;
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/DeliveryModel.php';
require_once __DIR__ . '/../models/AgentModel.php';

$delivery_model = new DeliveryModel($conn);
$agent_model    = new AgentModel($conn);
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assign'])) {
    $order_id  = (int)$_POST['order_id'];
    $agent_id  = (int)$_POST['agent_id'];
    $zone_name = $_POST['zone_name'];
    $delivery_model->assignAgent($order_id, $agent_id, $zone_name);
    $success = true;
}

$orders = $delivery_model->getOrdersReadyForDispatch();
$agents = $agent_model->getActiveAgents();

require_once __DIR__ . '/../views/delivery_manager/dispatch.php';
?>