<?php
include 'db_connection.php'; // Pastikan koneksi database


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $date = $_POST['deadline'];
    $query = "INSERT INTO tasks (title,deadline) VALUES ('$title','$date')";
    
    if ($mysqli->query($query)) {
        header("Location: v_tambah_tugas2.php?message=Status tugas berhasil diperbarui");
    } else {
        echo "Error: " . $mysqli->error;
    }
}
?>