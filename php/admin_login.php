<?php
require_once 'config.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");
    $admin = mysqli_fetch_assoc($result);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['username'];
        header('Location: admin_dashboard.php');
        exit();
    } else {
        $error = 'Invalid username or password!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - SRMS</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="login-page">
    <div class="login-box">
        <div class="logo">👨‍💼</div>
        <h2>Admin Login</h2>
        <p>Sign in to manage student results</p>

        <?php if ($error): ?>
            <div class="error-msg"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter admin username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter password" required>
            </div>
            <button type="submit" class="submit-btn">Login →</button>
        </form>

        <div class="back-link">
            <a href="../index.php">← Back to Home</a>
        </div>
        <p style="text-align:center;font-size:0.8rem;color:#aaa;margin-top:15px;">
            Default: admin / admin123
        </p>
    </div>
</div>
</body>
</html>
