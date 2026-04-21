<?php
session_start();
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['admin_id'])) { header('Location: admin_login.php'); exit(); }
$students = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM students"))['c'];
$subjects = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM subjects"))['c'];
$results  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM results"))['c'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - SRMS</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="dashboard">
    <aside class="sidebar">
        <div class="brand">
            <div style="font-size:2rem;">🎓</div>
            <h3>SRMS Admin</h3>
        </div>
        <nav>
            <a href="admin_dashboard.php" class="active"><span>🏠</span> Dashboard</a>
            <a href="manage_students.php"><span>👨‍🎓</span> Students</a>
            <a href="manage_subjects.php"><span>📚</span> Subjects</a>
            <a href="manage_results.php"><span>📋</span> Results</a>
            <a href="admin_logout.php" style="margin-top:30px;"><span>🚪</span> Logout</a>
        </nav>
    </aside>
    <main class="main-content">
        <div class="topbar">
            <h1>Dashboard</h1>
            <div class="user-info">
                <div class="avatar">A</div>
                <span><?= htmlspecialchars($_SESSION['admin_name']) ?></span>
            </div>
        </div>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue">👨‍🎓</div>
                <div class="stat-info"><h3><?= $students ?></h3><p>Total Students</p></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">📚</div>
                <div class="stat-info"><h3><?= $subjects ?></h3><p>Total Subjects</p></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange">📋</div>
                <div class="stat-info"><h3><?= $results ?></h3><p>Results Entered</p></div>
            </div>
        </div>
        <div class="table-card">
            <h2>Quick Actions</h2>
            <div style="display:flex;gap:15px;flex-wrap:wrap;padding:10px 0;">
                <a href="manage_students.php" class="add-btn">+ Add Student</a>
                <a href="manage_subjects.php" class="add-btn" style="background:linear-gradient(135deg,#1b5e20,#388e3c);">+ Add Subject</a>
                <a href="manage_results.php" class="add-btn" style="background:linear-gradient(135deg,#e65100,#f57c00);">+ Add Result</a>
            </div>
        </div>
        <div class="table-card">
            <h2>Recent Students</h2>
            <table>
                <thead>
                    <tr><th>Roll No</th><th>Name</th><th>Department</th><th>Semester</th></tr>
                </thead>
                <tbody>
                <?php
                $res = mysqli_query($conn, "SELECT * FROM students ORDER BY created_at DESC LIMIT 5");
                while ($row = mysqli_fetch_assoc($res)):
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['roll_no']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['department']) ?></td>
                    <td>Semester <?= $row['semester'] ?></td>
                </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>
