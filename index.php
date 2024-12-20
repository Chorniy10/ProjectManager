<?php
require_once 'TaskManager.php';

$taskManager = new TaskManager('tasks.json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $taskManager->addTask($_POST['task']);
                break;
            case 'delete':
                $taskManager->deleteTask($_POST['taskId']);
                break;
        }
    }
}

$tasks = $taskManager->getTasks();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
</head>
<body>
<h1>Task Manager</h1>

<form method="post">
    <input type="hidden" name="action" value="add">
    <input type="text" name="task" placeholder="Enter a new task" required>
    <button type="submit">Add Task</button>
</form>

<ul>
    <?php foreach ($tasks as $task): ?>
        <li>
            <?php echo htmlspecialchars($task['name']); ?>
            <form method="post" style="display:inline;">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="taskId" value="<?php echo $task['id']; ?>">
                <button type="submit">Delete</button>
            </form>
        </li>
    <?php endforeach; ?>
</ul>
</body>
</html>
