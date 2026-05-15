<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);  // For checking error
session_start();
require_once '../shared/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../login.php"); exit;
}

$email    = trim($_POST['email']);
$password = trim($_POST['password']);

$stmt = $conn->prepare("SELECT id, name, role, password_hash, is_active FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user || !password_verify($password, $user['password_hash'])) {
    header("Location: ../login.php?error=1"); exit;
}

if (!$user['is_active']) {
    header("Location: ../login.php?error=2"); exit;
}

if ($user['role'] === 'seller') {
    $stmt2 = $conn->prepare("SELECT is_approved FROM sellers WHERE user_id = ?");
    $stmt2->bind_param("i", $user['id']);
    $stmt2->execute();
    $seller = $stmt2->get_result()->fetch_assoc();
    if (!$seller || !$seller['is_approved']) {
        header("Location: ../login.php?error=3"); exit;
    }
}

$_SESSION['user_id']   = $user['id'];
$_SESSION['user_name'] = $user['name'];
$_SESSION['role']      = $user['role'];

switch ($user['role']) {
    case 'admin':            header("Location: /NextCart/admin/views/dashboard.php");    break;
    case 'seller':           header("Location: /NextCart/seller/views/dashboard.php");   break;
    case 'customer':         header("Location: /NextCart/customer/views/dashboard.php"); break;
    case 'delivery_manager': header("Location: /NextCart/delivery/views/dashboard.php"); break;
    default:                 header("Location: /NextCart/login.php");
}
exit;