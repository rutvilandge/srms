<?php
require_once 'config.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roll = mysqli_real_escape_string($conn, $_POST['roll_no']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM students WHERE roll_no='$roll'");
    $student = mysqli_fetch_assoc($result);

    if ($student && password_verify($password, $student['password'])) {
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
<head><meta charset="UTF-8"><title>Student Login - SRMS</title><link rel="stylesheet" href="../css/style.css"></head>
<body>
<div class="login-page">
    <div class="login-box">
        <div class="logo">👨‍🎓</div>
        <h2>Student Login</h2>
        <p>Enter your roll number to view results</p>
        <?php if ($error): ?><div class="error-msg"><?= $error ?></div><?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Roll Number</label>
                <input type="text" name="roll_no" placeholder="e.g. CS2021001" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter password" required>
            </div>
            <button type="submit" class="submit-btn">View My Results →</button>
        </form>
        <div class="back-link"><a href="../index.php">← Back to Home</a></div>
        <p style="text-align:center;font-size:0.8rem;color:#aaa;margin-top:15px;">Sample: CS2021001 / student123</p>
    </div>
</div>
</body>
</html>
