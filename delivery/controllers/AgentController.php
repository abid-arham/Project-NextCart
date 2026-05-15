<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'delivery_manager') {
    header("Location: /nextcart/controllers/LoginController.php");
    exit;
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/AgentModel.php';

$model = new AgentModel($conn);
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_agent'])) {
    $model->addAgent($_POST['name'], $_POST['phone'], $_POST['vehicle_type']);
    $success = true;
}

if (isset($_GET['toggle'])) {
    $model->toggleStatus((int)$_GET['toggle']);
    header("Location: /nextcart/controllers/AgentController.php");
    exit;
}

$agents = $model->getAllAgents();

require_once __DIR__ . '/../views/delivery_manager/agents.php';
?>