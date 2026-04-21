<?php
define('DB_HOST', 'sql100.infinityfree.com'); 
define('DB_USER', 'if0_41711243');       
define('DB_PASS', 'WeobiB4bxvA');        
define('DB_NAME', 'if0_41711243_srms_db');
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
