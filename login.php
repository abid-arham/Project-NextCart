<?php
session_start();

if (isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case 'admin':            header("Location: admin/views/dashboard.php");    exit;
        case 'seller':           header("Location: seller/views/dashboard.php");   exit;
        case 'customer':         header("Location: customer/views/dashboard.php"); exit;
        case 'delivery_manager': header("Location: delivery/views/dashboard.php"); exit;
    }
}

$error      = $_GET['error']      ?? '';
$registered = $_GET['registered'] ?? '';

$error_messages = [
    '1' => 'Invalid email or password.',
    '2' => 'Your account has been deactivated.',
    '3' => 'Your seller account is pending approval.',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — NextCart</title>
    <link rel="stylesheet" href="public/css/login.css">
</head>
<body>

<div class="login-page">

    <div class="brand">
        <h1>NextCart</h1>
        <p>Sign in to your account</p>
    </div>

    <?php if ($registered): ?>
        <div class="alert-success">Registration successful. You can now log in.</div>
    <?php endif; ?>

    <?php if ($error && isset($error_messages[$error])): ?>
        <div class="alert-danger"><?= $error_messages[$error] ?></div>
    <?php endif; ?>

    <form method="POST" action="controllers/AuthController.php" class="login-form">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="you@example.com" required autofocus>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn-submit">Login</button>
    </form>

    <div class="login-footer">
        <a href="customer/views/register.php">New customer? Register here</a>
        <span class="divider">or</span>
        <a href="seller/views/register.php">Want to sell? Apply as seller</a>
        <span class="divider">—</span>
        <a href="index.php">← Back to home</a>
    </div>

</div>

</body>
</html>