<?php
include 'connection.php';
include 'inputValidation.php';
session_start();

switch($_POST["type"]) {
    case "store": 
        store($_POST["fid"]);
        break;
    case "delete":
        delete($_POST["task_id"]);
        break;
    case "update": 
        update($_POST["id"]);
        break;
    case "sort":
        sorting($_POST["id"]);
        break;
    case "filter":
        filter($_POST["id"]);
        break;
}

function store($fid) {
    try
    {
        $database = new Connection();
        $check = new InputValidation();
        $db = $database->openConnection();
        $title = $check->validate($_POST['title']);
        $status = $check->validate($_POST['status']);
        $time = $check->validate($_POST['time']);
        $stm = $db->prepare("INSERT INTO `task`(`title`, `task_list_id`, `status`, `time`) VALUES (:title, :fid, :status, :time)");
        $stm->execute(array(':title' => $title, ':fid' => $fid, ':status' => $status, ':time' => $time));

        header("Location: http://localhost/todo");
    }
    catch (PDOException $e)
    {
        echo "There is some problem in connection: " . $e->getMessage();
    }
}

function delete($id) {
    try
    {
        $database = new Connection();
        $db = $database->openConnection();
        $sql = "DELETE FROM task WHERE `task_id` = $id" ;
        $affectedrows = $db->exec($sql);
        if(isset($affectedrows))
        {
            header("Location: http://localhost/todo");
        }          
    }

    catch (PDOException $e)
    {
        $_SESSION['error'] = "All tasks need to be done to check the list";
        header("Location: http://localhost/todo");
        exit();
        
    }
}

function update($id) {
    try
    {
        $database = new Connection();
        $check = new InputValidation();
        $title = $check->validate($_POST['title']);
        $status = $check->validate($_POST['status']);
        $time = $check->validate($_POST['time']);
        $db = $database->openConnection();
        $sql = "UPDATE `task` SET `title`='$title', `status`='$status', `time`='$time' WHERE `task_id` = $id";
        $db->exec($sql);  
        header("Location: http://localhost/todo");   
    }

    catch (PDOException $e)
    {
        $_SESSION['error'] = "SQL Error: $e";
        header("Location: http://localhost/todo");
        // echo $e;
        exit();
        
    }
}

function sorting($id) {
    $_SESSION['sort'] = $_POST['dir'];
    header("Location: http://localhost/todo");   
    
}

function filter($id) {

}