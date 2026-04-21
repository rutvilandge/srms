<?php
$host     = 'shinkansen.proxy.rlwy.net';
$username = 'root';
$password = 'XfJQFQOEsPfqDqbWjcBzsTXNgXMIVjlj';
$database = 'railway';
$port     = 21818;

$conn = mysqli_connect($host, $username, $password, $database, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
