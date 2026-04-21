<?php
$host     = 'mysql.railway.internal';
$username = 'root';
$password = 'XfJQFQOEsPfqDqbWjcBzsTXNgXMIVjlj';
$database = 'railway';
$port     = 3306;

$conn = mysqli_connect($host, $username, $password, $database, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
