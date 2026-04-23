<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/config.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roll = mysqli_real_escape_string($conn, $_POST['roll_no']);
    $password = $_POST['password'];
    $result = mysqli_query($conn, "SELECT * FROM students WHERE roll_no='$roll'");
    if (!$result) {
        die("Query Error: " . mysqli_error($conn));
    }
    $student = mysqli_fetch_assoc($result);
    if ($student && $password === $student['password']) {
        $_SESSION['student_id'] = $student['id'];
        $_SESSION['student_name'] = $student['name'];
        $_SESSION['student_roll'] = $student['roll_no'];
        header('Location: student_dashboard.php');
        exit();
    } else {
        $error = 'Invalid roll number or password!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login - SRMS</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .login-box { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h2 { text-align: center; margin-bottom: 30px; color: #333; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; color: #555; font-weight: bold; }
        input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; }
        input:focus { outline: none; border-color: #4CAF50; }
        .btn { width: 100%; padding: 12px; background: #4CAF50; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; }
        .btn:hover { background: #45a049; }
        .error { background: #ffe0e0; color: #c00; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
        .back { text-align: center; margin-top: 20px; }
        .back a { color: #4CAF50; text-decoration: none; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>🎓 Student Login</h2>
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Roll Number</label>
                <input type="text" name="roll_no" placeholder="Enter your roll number" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        <div class="back">
            <a href="../index.php">← Back to Home</a>
        </div>
    </div>
</body>
</html>
