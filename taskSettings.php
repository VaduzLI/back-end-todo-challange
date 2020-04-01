<?php
    include 'connection.php';

    try
    {
        $database = new Connection();
        $db = $database->openConnection();
        $stmt = $db->prepare("SELECT * FROM task WHERE task_id=?");
        $stmt->execute([$_POST["task_id"]]); 
        $task = $stmt->fetch();
    }

    catch (PDOException $e)
    {
        echo "There is some problem in connection: " . $e->getMessage();
    }  
?>

<html>
    <head>
        <link rel="stylesheet" href="styles/styles.css" type="text/css">
    </head>
    <body>
        <div class="addTaskBackground">
            <form method="POST" class="createListForm" action="taskController.php">
                <input type="hidden" name="id" value="<?php echo $_POST["task_id"] ?>">
                <input type="hidden" name="type" value="update">
                <input required class="listFormInput" type="text" name="title" id="title" value="<?php echo $task["title"] ?>">
                <select class="listFormInput" required name="status" id="status">
                    <option value="Todo">Todo</option>
                    <option value="Stuck">Stuck</option>
                    <option value="Doing">Doing</option>
                </select>
                <input class="listFormInput" required name="time" type="time">
                <input class="listFormSubmit" required type="submit" value="Update">
            </form>
        </div>
    </body>
</html>

