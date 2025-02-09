<h2>Tambah Tugas ke Daftar Tugas</h2>
<form action="aksi_list.php" method="POST">
    <label for="task_list_id">Pilih Daftar Tugas:</label><br>
    <select id="task_list_id" name="task_list_id" required>
        <?php
        // Ambil daftar tugas dari database
        include 'db_connection.php';
        $result = $mysqli->query("SELECT id, name FROM task_lists");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['name']}</option>";
        }
        ?>
    </select><br><br>
    
    <!-- <label for="title">Judul Tugas:</label><br>
    <input type="text" id="title" name="title" required><br><br>
    
    <label for="description">Deskripsi Tugas:</label><br>
    <textarea id="description" name="description"></textarea><br><br>
    
    <label for="deadline">Deadline:</label><br>
    <input type="datetime-local" id="deadline" name="deadline"><br><br>
    
    <input type="submit" value="Tambah Tugas"> -->
</form>
