<?php
include 'connection.php';
include 'inputValidation.php';
session_start();

switch($_POST["type"]) {
    case "store": 
        store();
        break;
    case "delete":
        delete($_POST["task_list_id"]);
        break;
    case "update": 
        update($_POST["id"]);
        break;
}

function store() {

    try
    {
        $database = new Connection();
        $check = new InputValidation();
        $db = $database->openConnection();
        $title = $check->validate($_POST['title']);
        
        // inserting data into create table using prepare statement to prevent from sql injections
        $stm = $db->prepare("INSERT INTO task_lists (title) VALUES (:title)") ;
        // inserting a record
        $stm->execute(array(':title' => $title));
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
        $sql = "DELETE FROM task_lists WHERE `task_list_id` = $id" ;
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
        $db = $database->openConnection();
        $sql = "UPDATE `task_lists` SET `title`='$title' WHERE `task_list_id` = $id";
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