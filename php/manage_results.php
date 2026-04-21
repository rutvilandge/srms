<?php
session_start();
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['admin_id'])) { header('Location: admin_login.php'); exit(); }
$msg = '';

function calcGrade($marks, $max) {
    $pct = ($marks / $max) * 100;
    if ($pct >= 90) return 'O';
    if ($pct >= 80) return 'A';
    if ($pct >= 70) return 'B+';
    if ($pct >= 60) return 'B';
    if ($pct >= 50) return 'C';
    return 'F';
}

if (isset($_POST['add_result'])) {
    $sid = (int)$_POST['student_id'];
    $subid = (int)$_POST['subject_id'];
    $marks = (int)$_POST['marks_obtained'];
    $year = mysqli_real_escape_string($conn, $_POST['exam_year']);
    // Get max marks
    $sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT max_marks FROM subjects WHERE id=$subid"));
    $grade = calcGrade($marks, $sub['max_marks']);
    $q = "INSERT INTO results (student_id,subject_id,marks_obtained,exam_year,grade) VALUES ($sid,$subid,$marks,'$year','$grade')
          ON DUPLICATE KEY UPDATE marks_obtained=$marks, exam_year='$year', grade='$grade'";
    if (mysqli_query($conn, $q)) $msg = '<div class="alert alert-success">Result saved! Grade: <b>'.$grade.'</b></div>';
    else $msg = '<div class="alert alert-error">'.mysqli_error($conn).'</div>';
}
if (isset($_GET['delete'])) {
    mysqli_query($conn, "DELETE FROM results WHERE id=".(int)$_GET['delete']);
    header('Location: manage_results.php'); exit();
}

$students_list = mysqli_query($conn, "SELECT id,roll_no,name FROM students ORDER BY roll_no");
$subjects_list = mysqli_query($conn, "SELECT id,subject_code,subject_name FROM subjects ORDER BY subject_code");

$results = mysqli_query($conn, "
    SELECT r.*, s.name as student_name, s.roll_no, sub.subject_name, sub.subject_code, sub.max_marks
    FROM results r
    JOIN students s ON r.student_id = s.id
    JOIN subjects sub ON r.subject_id = sub.id
    ORDER BY s.roll_no, sub.subject_code
");
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Manage Results - SRMS</title><link rel="stylesheet" href="../css/style.css"></head>
<body>
<div class="dashboard">
    <aside class="sidebar">
        <div class="brand"><div style="font-size:2rem;">🎓</div><h3>SRMS Admin</h3></div>
        <nav>
            <a href="admin_dashboard.php"><span>🏠</span> Dashboard</a>
            <a href="manage_students.php"><span>👨‍🎓</span> Students</a>
            <a href="manage_subjects.php"><span>📚</span> Subjects</a>
            <a href="manage_results.php" class="active"><span>📋</span> Results</a>
            <a href="admin_logout.php" style="margin-top:30px;"><span>🚪</span> Logout</a>
        </nav>
    </aside>
    <main class="main-content">
        <div class="topbar"><h1>Manage Results</h1></div>
        <?= $msg ?>
        <div class="form-card" style="margin-bottom:25px;">
            <h2>Add / Update Result</h2>
            <form method="POST">
                <div class="form-row">
                    <div class="form-group"><label>Student</label>
                        <select name="student_id" required>
                            <option value="">Select Student</option>
                            <?php
                            $tmp = mysqli_query($conn, "SELECT id,roll_no,name FROM students ORDER BY roll_no");
                            while($r = mysqli_fetch_assoc($tmp)) echo "<option value='{$r['id']}'>{$r['roll_no']} - {$r['name']}</option>";
                            ?>
                        </select>
                    </div>
                    <div class="form-group"><label>Subject</label>
                        <select name="subject_id" required>
                            <option value="">Select Subject</option>
                            <?php
                            $tmp = mysqli_query($conn, "SELECT id,subject_code,subject_name FROM subjects ORDER BY subject_code");
                            while($r = mysqli_fetch_assoc($tmp)) echo "<option value='{$r['id']}'>{$r['subject_code']} - {$r['subject_name']}</option>";
                            ?>
                        </select>
                    </div>
                    <div class="form-group"><label>Marks Obtained</label><input type="number" name="marks_obtained" min="0" max="100" required></div>
                    <div class="form-group"><label>Exam Year</label><input type="text" name="exam_year" value="2024" placeholder="2024" required></div>
                </div>
                <button type="submit" name="add_result" class="submit-btn" style="max-width:200px;">Save Result</button>
            </form>
        </div>

        <div class="table-card">
            <h2>All Results</h2>
            <table>
                <thead><tr><th>Roll No</th><th>Student</th><th>Subject</th><th>Marks</th><th>Max</th><th>Grade</th><th>Year</th><th>Action</th></tr></thead>
                <tbody>
                <?php while($row = mysqli_fetch_assoc($results)): 
                    $gc = substr($row['grade'],0,1);
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['roll_no']) ?></td>
                    <td><?= htmlspecialchars($row['student_name']) ?></td>
                    <td><?= htmlspecialchars($row['subject_code']) ?></td>
                    <td><?= $row['marks_obtained'] ?></td>
                    <td><?= $row['max_marks'] ?></td>
                    <td><span class="grade-badge grade-<?= $gc ?>"><?= $row['grade'] ?></span></td>
                    <td><?= $row['exam_year'] ?></td>
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

