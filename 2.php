<!DOCTYPE html>
<html>
<head>
    <title>Simple To-Do List</title>
</head>
<body>
    <h1>My To-Do List</h1>

    <form action="index.php" method="POST">
        <input type="text" name="task" placeholder="Add a new task">
        <button type="submit" name="addTask">Add</button>
    </form>

    <?php
    // Handle task addition
    if (isset($_POST['addTask'])) {
        $task = $_POST['task'];
        if (!empty($task)) {
            $file = fopen('tasks.txt', 'a');
            fwrite($file, $task . "\n");
            fclose($file);
        }
    }

    // Handle task deletion
    if (isset($_POST['deleteTask'])) {
        $taskToDelete = $_POST['deleteTask'];
        $tasks = file('tasks.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $updatedTasks = array_diff($tasks, [$taskToDelete]);
        file_put_contents('tasks.txt', implode("\n", $updatedTasks));
    }

    // Display tasks
    $tasks = file('tasks.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (!empty($tasks)) {
        echo '<ul>';
        foreach ($tasks as $task) {
            echo '<li>' . $task . ' <form action="index.php" method="POST" style="display: inline;"><button type="submit" name="deleteTask" value="' . $task . '">Delete</button></form></li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No tasks yet. Add some tasks above.</p>';
    }
    ?>

</body>
</html>
