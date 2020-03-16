<?php

include 'connection.php';
session_start();

try
{
    $database = new Connection();
    $db = $database->openConnection();
    $sql = "SELECT * FROM task_lists " ;
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
        <div class="taskbar">
            <div class="time">
                <div class="welcomeText">
                    <span>Hello Wouter</span>
                </div>
                <div class="hourTime">
                    <span><?php echo date("h:i") ?></span>
                </div>
                <div class="dayTime">
                    <span><?php echo date('l jS \of F Y'); ?></span>
                </div>
            </div>
            <button onclick="window.location.href='addTask.php'" class="addTaskButton">+ New task list</button>
        </div>
        <div class="tasksContainer">
        <?php if(isset($_SESSION['error']))
        {
            
            echo $_SESSION['error'];
            unset($_SESSION['error']);
        } ?>
            <?php foreach ($db->query($sql) as $row) { ?>
            <div class="taskList">
                <form method="post" action="listController.php">
                    <input type="hidden" name="type" value="delete">
                    <input type="hidden" name="task_list_id" value="<?php echo $row['task_list_id'] ?>">
                    <input type="submit" class="deleteTaskListButton" value="&#10004;"></input>
                </form>
                <form action="settings.php">
                    <input type="hidden" name="id" value="<?php echo $row['task_list_id'] ?>">
                    <input type="submit" class="settingsTaskListButton" value="&#9881;">    
                </form>
                
                
                <div class="taskListTextContainer">
                    <button onclick="openTaskList(<?php echo $row['task_list_id'] ?>)" class="taskListDropDownButton"><?php echo $row['title'] ?></button>
                </div>
                <div style="display: none;" id="<?php echo 'taskItem'.$row['task_list_id'] ?>" class="taskItem">
                    <div class="taskItemContent">
                        <form method="post" action="taskController.php">
                            <input name="type" type="hidden" value="store">
                            <input name="fid" type="hidden" value=<?php echo $row['task_list_id'] ?>>
                            <input name="title" type="text">
                            <input type="submit" value="+ New Task">
                        </form>
                        <?php foreach($db->query("SELECT * FROM task WHERE task_list_id = " . $row["task_list_id"]) as $task) { ?>
                        <div class="task">
                            <?php echo $task['title'] ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </body>
</html>

<script src="scripts/script.js"></script>