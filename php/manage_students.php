<?php
session_start();
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['admin_id'])) { header('Location: admin_login.php'); exit(); }

$msg = '';

// Handle Add Student
if (isset($_POST['add_student'])) {
    $roll = mysqli_real_escape_string($conn, $_POST['roll_no']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $dept = mysqli_real_escape_string($conn, $_POST['department']);
    $sem = (int)$_POST['semester'];

    $q = "INSERT INTO students (roll_no,name,email,password,department,semester) VALUES ('$roll','$name','$email','$pass','$dept',$sem)";
    if (mysqli_query($conn, $q)) $msg = '<div class="alert alert-success">Student added successfully!</div>';
    else $msg = '<div class="alert alert-error">Error: ' . mysqli_error($conn) . '</div>';
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM students WHERE id=$id");
    header('Location: manage_students.php');
    exit();
}

$students = mysqli_query($conn, "SELECT * FROM students ORDER BY roll_no");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Students - SRMS</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="dashboard">
    <aside class="sidebar">
        <div class="brand"><div style="font-size:2rem;">🎓</div><h3>SRMS Admin</h3></div>
        <nav>
            <a href="admin_dashboard.php"><span>🏠</span> Dashboard</a>
            <a href="manage_students.php" class="active"><span>👨‍🎓</span> Students</a>
            <a href="manage_subjects.php"><span>📚</span> Subjects</a>
            <a href="manage_results.php"><span>📋</span> Results</a>
            <a href="admin_logout.php" style="margin-top:30px;"><span>🚪</span> Logout</a>
        </nav>
    </aside>

    <main class="main-content">
        <div class="topbar"><h1>Manage Students</h1></div>
        <?= $msg ?>

        <!-- Add Student Form -->
        <div class="form-card" style="margin-bottom:25px;">
            <h2>Add New Student</h2>
            <form method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label>Roll Number</label>
                        <input type="text" name="roll_no" placeholder="e.g. CS2021001" required>
                    </div>
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" placeholder="Student name" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="student@email.com" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Set password" required>
                    </div>
                    <div class="form-group">
                        <label>Department</label>
                        <select name="department" required>
                            <option value="">Select Department</option>
                            <option>Computer Science</option>
                            <option>Information Technology</option>
                            <option>Electronics</option>
                            <option>Mechanical</option>
                            <option>Civil</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Semester</label>
                        <select name="semester" required>
                            <?php for($i=1;$i<=8;$i++) echo "<option value='$i'>Semester $i</option>"; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" name="add_student" class="submit-btn" style="max-width:200px;">Add Student</button>
            </form>
        </div>

        <!-- Students Table -->
        <div class="table-card">
            <h2>All Students</h2>
            <table>
                <thead>
                    <tr><th>#</th><th>Roll No</th><th>Name</th><th>Email</th><th>Department</th><th>Semester</th><th>Action</th></tr>
                </thead>
                <tbody>
                <?php $i=1; while ($row = mysqli_fetch_assoc($students)): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($row['roll_no']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['department']) ?></td>
                    <td>Sem <?= $row['semester'] ?></td>
                    <td class="action-links">
                        <a href="?delete=<?= $row['id'] ?>" class="del" onclick="return confirm('Delete this student?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>
