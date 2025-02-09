<?php
include 'db_connection.php';

// Ambil daftar tugas dan sub-tugas
$query = "SELECT * FROM tasks INNER JOIN task_lists ON tasks.id_tasks=task_lists.id_tasks
        INNER JOIN users ON users.id_user=tasks.id_user ORDER BY title";
$result = $mysqli->query($query);
$query = "SELECT 
            t.id_tasks AS task_id, 
            t.title AS task_title, 
            s.Id AS sub_id, 
            s.Name AS sub_task_title, 
            s.status_tasks
          FROM tasks t 
          LEFT JOIN task_lists s ON t.id_tasks=s.id_tasks
          ORDER BY t.id_tasks, s.Id";

$result = $mysqli->query($query);

// Menyusun hasil ke dalam array
$tasks = [];
while ($row = $result->fetch_assoc()) {
    $task_id = $row['task_id'];
    if (!isset($tasks[$task_id])) {
        $tasks[$task_id] = [
            'title' => $row['task_title'],
            'sub_tasks' => []
        ];
    }
    if (!empty($row['sub_task_title'])) {
        $tasks[$task_id]['sub_tasks'][] = [
            'id' => $row['sub_id'],
            'title' => $row['sub_task_title'],
            'status_tasks' => $row['status_tasks']
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Daftar Tugas</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .completed {
            text-decoration: line-through;
            color: gray;
        }
    </style>
</head>
<body>

<h2>Daftar Tugas</h2>
<dl>
    <?php foreach ($tasks as $task) { ?>
        <dt>
            <strong><?php echo htmlspecialchars($task['title']); ?></strong>
            <?php if (!empty($task['sub_tasks'])) { ?>
              
                    <?php foreach ($task['sub_tasks'] as $sub_task) { ?>
                        <dd>
                            <input type="checkbox" id="tampildata" class="subtask-checkbox" 
                                   data-id="<?php echo $sub_task['id']; ?>"
                                   <?php echo ($sub_task['status_tasks'] == 'Selesai') ? 'checked disabled' : ''; ?>>
                            <span class="<?php echo ($sub_task['status_tasks'] == 'Selesai') ? 'completed' : ''; ?>">
                                <?php echo htmlspecialchars($sub_task['title']); ?>
                            </span>
                    </dd>
                    <?php } ?>
                   
            <?php } ?>
                    </dt>
    <?php } ?>
                    </dl>

<script>
$(document).ready(function() {
    $(".subtask-checkbox").on("change", function() {
        let subtaskId = $(this).data("id");
        let isCompleted = $(this).is(":checked") ? "Selesai" : "Belum Selesai";
        let taskText = $(this).next("span");

        $.ajax({
            url: "update_task_status.php",
            type: "POST",
            data: { Id: subtaskId, status_tasks: isCompleted },
            success: function(result){
                //redirect ke halaman yang sama
                location.reload();
                // $("#tampildata").load("v_daftar_tugas.php");
            }
            // success: function(response) {
            //     if (isCompleted === "selesai") {
            //         taskText.addClass("completed");
            //     } else {
            //         taskText.removeClass("completed");
            //     }
            // }
        });
    });
});
</script>

</body>
</html>
