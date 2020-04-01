<?php
    include 'connection.php';

    try
    {
        $database = new Connection();
        $db = $database->openConnection();
        $stmt = $db->prepare("SELECT * FROM task_lists WHERE task_list_id=?");
        $stmt->execute([$_GET["id"]]); 
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
            <form method="POST" class="createListForm" action="listController.php">
            <span class="addTaskHeader">Update TaskList</span>
                <input type="hidden" name="id" value="<?php echo $_GET["id"] ?>">
                <input type="hidden" name="type" value="update">
                <input class="listFormInput" placeholder="Title" required type="text" name="title" id="title" value="<?php echo $task["title"] ?>">
                <input class="listFormSubmit" type="submit" value="Update">
            </form>
        </div>
    </body>
</html>

