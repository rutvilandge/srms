<?php
session_start();
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['student_id'])) { header('Location: student_login.php'); exit(); }

$sid = (int)$_SESSION['student_id'];

$student = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM students WHERE id=$sid"));

$results = mysqli_query($conn, "
    SELECT r.*, sub.subject_name, sub.subject_code, sub.max_marks
    FROM results r
    JOIN subjects sub ON r.subject_id = sub.id
    WHERE r.student_id = $sid
    ORDER BY sub.subject_code
");

$total_marks = 0;
$total_max = 0;
$pass_count = 0;
$fail_count = 0;
$rows = [];
while ($row = mysqli_fetch_assoc($results)) {
    $rows[] = $row;
    $total_marks += $row['marks_obtained'];
    $total_max += $row['max_marks'];
    if ($row['grade'] !== 'F') $pass_count++;
    else $fail_count++;
}
$percentage = $total_max > 0 ? round(($total_marks / $total_max) * 100, 2) : 0;
$overall_grade = 'F';
if ($percentage >= 90) $overall_grade = 'O';
elseif ($percentage >= 80) $overall_grade = 'A';
elseif ($percentage >= 70) $overall_grade = 'B+';
elseif ($percentage >= 60) $overall_grade = 'B';
elseif ($percentage >= 50) $overall_grade = 'C';
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>My Results - SRMS</title><link rel="stylesheet" href="../css/style.css"></head>
<body>
<div style="background:#f0f4f8;min-height:100vh;padding:30px 20px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:25px;max-width:900px;margin-left:auto;margin-right:auto;">
        <h1 style="color:#1a237e;font-size:1.5rem;">🎓 My Academic Results</h1>
        <a href="student_logout.php" style="color:#c62828;text-decoration:none;font-size:0.9rem;">🚪 Logout</a>
    </div>
    <div style="max-width:900px;margin:0 auto;">
    <div class="result-header">
        <div class="avatar-big">👨‍🎓</div>
        <div>
            <h2><?= htmlspecialchars($student['name']) ?></h2>
            <p>Roll No: <?= htmlspecialchars($student['roll_no']) ?> &nbsp;|&nbsp; <?= htmlspecialchars($student['department']) ?></p>
            <span class="semester-tag">Semester <?= $student['semester'] ?></span>
        </div>
    </div>
    <div class="summary-cards">
        <div class="summary-card"><h4><?= $total_marks ?>/<?= $total_max ?></h4><p>Total Marks</p></div>
        <div class="summary-card"><h4><?= $percentage ?>%</h4><p>Percentage</p></div>
        <div class="summary-card"><h4><?= $overall_grade ?></h4><p>Overall Grade</p></div>
        <div class="summary-card"><h4 class="pass"><?= $pass_count ?></h4><p>Subjects Passed</p></div>
        <?php if ($fail_count > 0): ?>
        <div class="summary-card"><h4 class="fail"><?= $fail_count ?></h4><p>Subjects Failed</p></div>
        <?php endif; ?>
    </div>
    <div class="table-card">
        <h2>Subject-wise Result</h2>
        <?php if (empty($rows)): ?>
            <p style="color:#888;padding:20px;">No results found yet. Please contact your admin.</p>
        <?php else: ?>
        <table>
            <thead>
                <tr><th>#</th><th>Subject Code</th><th>Subject Name</th><th>Marks</th><th>Max Marks</th><th>%</th><th>Grade</th><th>Status</th></tr>
            </thead>
            <tbody>
            <?php $i=1; foreach($rows as $row):
                $pct = round(($row['marks_obtained']/$row['max_marks'])*100,1);
                $gc = substr($row['grade'],0,1);
                $status = ($row['grade'] !== 'F') ? '<span style="color:#2e7d32;font-weight:600;">PASS</span>' : '<span style="color:#c62828;font-weight:600;">FAIL</span>';
            ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= htmlspecialchars($row['subject_code']) ?></td>
                <td><?= htmlspecialchars($row['subject_name']) ?></td>
                <td><?= $row['marks_obtained'] ?></td>
                <td><?= $row['max_marks'] ?></td>
                <td><?= $pct ?>%</td>
                <td><span class="grade-badge grade-<?= $gc ?>"><?= $row['grade'] ?></span></td>
                <td><?= $status ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div style="margin-top:25px;padding:15px;background:#f9f9ff;border-radius:8px;font-size:0.85rem;color:#555;">
            <strong>Grading Scale:</strong> &nbsp;
            O (Outstanding ≥90%) &nbsp;|&nbsp; A (≥80%) &nbsp;|&nbsp; B+ (≥70%) &nbsp;|&nbsp; B (≥60%) &nbsp;|&nbsp; C (≥50%) &nbsp;|&nbsp; F (Below 50%)
        </div>
        <?php endif; ?>
    </div>
    </div>
</div>
</body>
</html>
