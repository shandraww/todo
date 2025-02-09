<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'todo';

$mysqli = new mysqli($host, $user, $password, $dbname);

if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}
?>
