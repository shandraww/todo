<?php
include 'db_connection.php';

// Filter Tugas
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
if ($filter == 'Selesai') {
    $query = "SELECT * FROM tasks INNER JOIN task_lists ON task_lists.Id=tasks.task_list_id
        INNER JOIN users ON users.id_user=tasks.id_user
        WHERE status_tasks='Selesai' ORDER BY created_at";
} elseif ($filter == 'Belum Selesai') {
    $query = "SELECT * FROM tasks INNER JOIN task_lists ON task_lists.Id=tasks.task_list_id
        INNER JOIN users ON users.id_user=tasks.id_user
        WHERE status_tasks ='Belum Selesai' ORDER BY created_at";
} else {
    $query = "SELECT * FROM tasks INNER JOIN task_lists ON task_lists.Id=tasks.task_list_id
        INNER JOIN users ON users.id_user=tasks.id_user ORDER BY status_tasks";
}
$result = $mysqli->query($query);

// Hitung jumlah tugas
$total_tasks = $mysqli->query("SELECT COUNT(*) AS total FROM task_lists")->fetch_assoc()['total'];
$completed_tasks = $mysqli->query("SELECT COUNT(*) AS completed FROM task_lists WHERE status_tasks='Selesai'")->fetch_assoc()['completed'];
$not_completed_tasks = $total_tasks - $completed_tasks;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
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
        .add-task-form input[type="text"], .add-task-form input[type="datetime-local"], .add-task-form input[type="submit"] {
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
    <h2>To-Do List</h2>

    <div style="margin-bottom: 20px; padding: 10px; background-color: #f0f0f0; border-radius: 4px;">
        <p>Total Tugas: <?php echo $total_tasks; ?></p>
        <p>Selesai: <?php echo $completed_tasks; ?></p>
        <p>Belum Selesai: <?php echo $not_completed_tasks; ?></p>
    </div>

    <form method="GET" action="index.php">
        <select name="filter" onchange="this.form.submit();">
            <option value="" <?php echo empty($filter) ? 'selected' : ''; ?>>Semua</option>
            <option value="completed" <?php echo $filter == 'completed' ? 'selected' : ''; ?>>Selesai</option>
            <option value="not_completed" <?php echo $filter == 'not_completed' ? 'selected' : ''; ?>>Belum Selesai</option>
        </select>
    </form>
    <div class="task-container">
    <form action="update_task_status.php" method="POST">
    <?php while ($task = $result->fetch_assoc()) { ?>
        <div class="task <?php echo $task['status_tasks'] == 'Selesai' ? 'completed' : ''; ?>">
        <div>
            <!-- Checkbox -->
             <dl><span><h3><?php echo $task['title']; ?></h3></span>
            <input type="hidden" name="task_id" value="<?php echo $task['Id']; ?>">
            <dt><dd><input type="checkbox" name="status_tasks" 
                   <?php echo $task['status_tasks'] == 'Selesai' ? 'checked disabled' : ''; ?>
                   onchange="this.form.submit();">
            <span><?php echo $task['Name']; ?></span></dd>
            </dt>
             </dl>
        </div>
                </form>
                <button href="edit_task.php?id=<?php echo $task['Id']; ?>">Ubah</button>
                <form action="delete_task.php" method="POST" style="display: inline;">
                    <input type="hidden" name="task_id" value="<?php echo $task['Id']; ?>">
                    <button type="submit">Hapus</button>
            </div>
        <?php } ?>
    </form>
    </div>
</body>
</html>
