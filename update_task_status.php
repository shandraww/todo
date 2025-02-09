<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_id = intval($_POST['task_id']);
    $is_completed = isset($_POST['status_tasks']) ? 'Selesai' : 'Belum selesai';

    // Update status tugas di database
    $query = "UPDATE task_lists SET status_tasks = '$is_completed' WHERE Id = $task_id";
    if ($mysqli->query($query)) {
        header("Location: v_tambah_tugas2.php?message=Status tugas berhasil diperbarui");
    } else {
        echo "Error: " . $mysqli->error;
    }
}
?>
