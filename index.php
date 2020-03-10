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
            <button class="addTaskButton">+ New task list</button>
        </div>
        <div class="tasksContainer">
            <div class="taskList">
                <button class="deleteTaskListButton">&#10004;</button>
                <div class="taskListTextContainer">
                    <span>C</span>
                    <span class="taskListName">Some Task</span>
                    <button>^</button>
                </div>
                <div class="taskItem">
                    <span>een taak</span>
                </div>
            </div>
        </div>
    </body>
</html>