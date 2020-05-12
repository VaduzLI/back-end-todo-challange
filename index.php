<?php

include 'connection.php';
session_start();

try
{
    $database = new Connection();
    $db = $database->openConnection();
    $sql = "SELECT * FROM task_lists";
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
            ?>
                <div class="errorContainer">

                    <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>

                </div>
            <?php

        } ?>
            <?php foreach ($db->query($sql) as $row) { ?>
            <div class="taskList">
                <form method="post" action="listController.php">
                    <input type="hidden" name="type" value="delete">
                    <input type="hidden" name="task_list_id" value="<?php echo $row['task_list_id'] ?>">
                    <input type="submit" class="deleteTaskListButton" value="&#10004;"></input>
                </form>
                <form action="listSettings.php">
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
                            <input required name="title" type="text">
                            <select name="status" id="status">
                                <option value="Todo">Todo</option>
                                <option value="Stuck">Stuck</option>
                                <option value="Doing">Doing</option>
                            </select>
                            <input required name="time" type="time">
                            <input type="submit" value="+ New Task">
                        </form>
                        <div class="sortContainer">
                            <form>
                                <select name="dir" id="">
                                    <option value="ASC">ASC</option>
                                    <option value="DESC">DESC</option>
                                </select>

                                <select name="search" id="">
                                    <option value="All">All</option>
                                    <option value="Todo">Todo</option>
                                    <option value="Stuck">Stuck</option>
                                    <option value="Doing">Doing</option>
                                </select>
                                <input type="submit" value="Search">
                            </form>
                        </div>
                        <?php 
                            $taskid = $row["task_list_id"];
                            $dir = $_GET['dir'];
                            $search = $_GET['search'];
                            unset($sql);
                            if (!is_null($_GET['search']) && $_GET['search'] !== "All") {
                                $sql[] = "AND status = '$search'";
                            }
                            if (!is_null($_GET['dir'])) {
                                $sql[] = "ORDER BY status $dir";
                            }
                            $query = "SELECT * FROM task";

                            $query .= " WHERE task_list_id = '$taskid' " . implode(' ', $sql);
                        ?>
                        <?php foreach($db->query($query) as $task) { ?>
                        <div class="task">
                        <div style="float: left">
                            <div>Name: <?php echo $task['title'] ?></div>
                            <div>Status: <?php echo $task['status'] ?></div>
                            <div>Finish: <?php echo $task['time'] ?></div>
                        </div>
                            <div style="margin-left: auto">
                            <form method="post" style="float: right;" class="taskForm" action="taskSettings.php">
                                <input type="hidden" name="task_id" value=<?php echo $task['task_id'] ?>>
                                <input type="submit" value="&#9881;">
                            </form>
                            <form method="post" style="float: right" class="taskForm" action="taskController.php">
                                <input type="hidden" name="type" value="delete">
                                <input type="hidden" name="task_id" value=<?php echo $task['task_id'] ?>>
                                <input type="submit" value="&#10004;">
                            </form>
                            </div>
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