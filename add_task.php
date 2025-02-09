<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = trim($_POST['id_tasks']);
    $Name = trim($_POST['deskripsi']);
    // $deadline = !empty($_POST['deadline']) ? $_POST['deadline'] : null;

    // Insert data ke tabel tasks
    $query = "INSERT INTO task_lists (id_tasks, Name, status_tasks) VALUES ('$id', '$Name', 'Belum Selesai')";
    if ($mysqli->query($query)) {
        header("Location: v_tambah_tugas2.php?message=Tugas berhasil ditambahkan");
    } else {
        echo "Error: " . $mysqli->error;
    }
}
?>
