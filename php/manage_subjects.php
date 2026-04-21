<?php
session_start();
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['admin_id'])) { header('Location: admin_login.php'); exit(); }
$msg = '';

if (isset($_POST['add_subject'])) {
    $code = mysqli_real_escape_string($conn, $_POST['subject_code']);
    $name = mysqli_real_escape_string($conn, $_POST['subject_name']);
    $dept = mysqli_real_escape_string($conn, $_POST['department']);
    $sem = (int)$_POST['semester'];
    $max = (int)$_POST['max_marks'];
    $q = "INSERT INTO subjects (subject_code,subject_name,department,semester,max_marks) VALUES ('$code','$name','$dept',$sem,$max)";
    if (mysqli_query($conn, $q)) $msg = '<div class="alert alert-success">Subject added successfully!</div>';
    else $msg = '<div class="alert alert-error">Error: ' . mysqli_error($conn) . '</div>';
}
if (isset($_GET['delete'])) {
    mysqli_query($conn, "DELETE FROM subjects WHERE id=".(int)$_GET['delete']);
    header('Location: manage_subjects.php'); exit();
}
$subjects = mysqli_query($conn, "SELECT * FROM subjects ORDER BY semester, subject_code");
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Manage Subjects - SRMS</title><link rel="stylesheet" href="../css/style.css"></head>
<body>
<div class="dashboard">
    <aside class="sidebar">
        <div class="brand"><div style="font-size:2rem;">🎓</div><h3>SRMS Admin</h3></div>
        <nav>
            <a href="admin_dashboard.php"><span>🏠</span> Dashboard</a>
            <a href="manage_students.php"><span>👨‍🎓</span> Students</a>
            <a href="manage_subjects.php" class="active"><span>📚</span> Subjects</a>
            <a href="manage_results.php"><span>📋</span> Results</a>
            <a href="admin_logout.php" style="margin-top:30px;"><span>🚪</span> Logout</a>
        </nav>
    </aside>
    <main class="main-content">
        <div class="topbar"><h1>Manage Subjects</h1></div>
        <?= $msg ?>
        <div class="form-card" style="margin-bottom:25px;">
            <h2>Add New Subject</h2>
            <form method="POST">
                <div class="form-row">
                    <div class="form-group"><label>Subject Code</label><input type="text" name="subject_code" placeholder="e.g. CS501" required></div>
                    <div class="form-group"><label>Subject Name</label><input type="text" name="subject_name" placeholder="Subject name" required></div>
                    <div class="form-group"><label>Department</label>
                        <select name="department" required>
                            <option value="">Select</option>
                            <option>Computer Science</option><option>Information Technology</option>
                            <option>Electronics</option><option>Mechanical</option><option>Civil</option>
                        </select>
                    </div>
                    <div class="form-group"><label>Semester</label>
                        <select name="semester" required><?php for($i=1;$i<=8;$i++) echo "<option value='$i'>Semester $i</option>"; ?></select>
                    </div>
                    <div class="form-group"><label>Max Marks</label><input type="number" name="max_marks" value="100" min="1" required></div>
                </div>
                <button type="submit" name="add_subject" class="submit-btn" style="max-width:200px;">Add Subject</button>
            </form>
        </div>
        <div class="table-card">
            <h2>All Subjects</h2>
            <table>
                <thead><tr><th>#</th><th>Code</th><th>Subject Name</th><th>Department</th><th>Semester</th><th>Max Marks</th><th>Action</th></tr></thead>
                <tbody>
                <?php $i=1; while($row = mysqli_fetch_assoc($subjects)): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= htmlspecialchars($row['subject_code']) ?></td>
                    <td><?= htmlspecialchars($row['subject_name']) ?></td>
                    <td><?= htmlspecialchars($row['department']) ?></td>
                    <td>Sem <?= $row['semester'] ?></td>
                    <td><?= $row['max_marks'] ?></td>
                    <td class="action-links"><a href="?delete=<?= $row['id'] ?>" class="del" onclick="return confirm('Delete?')">Delete</a></td>
                </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>
