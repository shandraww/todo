<?php
include 'db_connection.php';

// Ambil semua tugas dari database
$query = "SELECT * FROM tasks INNER JOIN task_lists ON tasks.id_tasks=task_lists.id_tasks
        INNER JOIN users ON users.id_user=tasks.id_user ORDER BY title";
$result = $mysqli->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .task-container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
        }
        .task {
            display: flex;
            align-items: center;
            margin: 10px 0;
            padding: 10px;
            border-bottom: 1px solid #ddd;

        }
  
        .task:last-child {
            border-bottom: none;
        }
        .task.completed {
            text-decoration: line-through;
            color: #888;
        }

        .task.completed span{
           pointer-events: none;
        }
        input[type="checkbox"] {
            margin-right: 10px;
        }
        .add-task-form input[type="text"], .add-task-form input[type="date"], .add-task-form input[type="submit"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .add-task-form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="task-container">
        <h2>To-Do List</h2>
        <form action="update_task_status.php" method="POST">
            
            <?php while ($task = $result->fetch_assoc()) { ?>
                <div class="task <?php echo $task['status_tasks'] == 'Selesai' ? 'completed' : ''; ?>">
                
        <div>
            <!-- Checkbox -->
             <!-- disini pengkondisian if untuk mengecek jumlah tugas
              apabila tugas lebih dari 1 maka menampilkan judul satu kali, kemudian sebaliknya -->
            <dl><span><h3><?php echo $task['title']; ?></h3></span>
            <input type="hidden" name="task_id" value="<?php echo $task['Id']; ?>">
            <dt><dd><input type="checkbox" name="status_tasks" 
                   <?php echo $task['status_tasks'] == 'Selesai' ? 'checked disabled' : ''; ?>
                   onchange="this.form.submit();">
            <span><?php echo $task['Name']; ?></span></dd>
            </dt>
             </dl>
        </div>
    </div>
            <?php } ?>
        </form>

        <h3>Tambah Daftar Tugas</h3>
        <!-- Tombol Tambah Tugas -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">
    Tambah Tugas
</button>
        <form class="add-task-form" action="aksi_tambah_tugas.php" method="POST">
            <input type="text" name="title" placeholder="Judul Tugas" required>
            <!-- <input type="datetime-local" name="deadline" placeholder="Deadline"> -->
            <input type="date" name="deadline" placeholder="Deadline" required>
            <input type="submit" value="Tambah Tugas">
        </form>
    </div>

    <!-- Modal Tambah Tugas -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTaskModalLabel">Tambah Tugas Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="add_task.php" method="POST">
                <div class="modal-body">
                    <!-- Input Judul Tugas -->
                    <div class="mb-3">
                      
                        <label for="taskTitle" class="form-label">Pilih Daftar Tugas:</label><br>
    <select id="taskTitle" class="form-control" name="id_tasks" required>
        <?php
        // Ambil daftar tugas dari database
        $result = $mysqli->query("SELECT id_tasks, title FROM tasks");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id_tasks']}'>{$row['title']}</option>";
        }
        ?>
    </select>
                    </div>
                    <!-- Input Deskripsi -->
                    <div class="mb-3">
                        <label for="taskDescription" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" id="taskDescription" rows="3" placeholder="Masukkan deskripsi tugas"></textarea>
                    </div>
                    <!-- Input Deadline -->
                    <!-- <div class="mb-3">
                        <label for="taskDeadline" class="form-label">Deadline</label>
                        <input type="datetime-local" name="deadline" class="form-control" id="taskDeadline">
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah Tugas</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
