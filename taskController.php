<?php
include 'connection.php';
include 'inputValidation.php';

switch($_POST["type"]) {
    case "store": 
        store($_POST["fid"]);
        break;
    case "delete":
        delete($_POST["id"]);
        break;
    case "update": 
        update($_POST["id"]);
        break;
}

function store($fid) {
    try
    {
        $database = new Connection();
        $check = new InputValidation();
        $db = $database->openConnection();
        $title = $check->validate($_POST['title']);
        $stm = $db->prepare("INSERT INTO `task`(`title`, `task_list_id`) VALUES (:title, :fid)");
        $stm->execute(array(':title' => $title, ':fid' => $fid));

        header("Location: http://localhost/todo");
    }
    catch (PDOException $e)
    {
        echo "There is some problem in connection: " . $e->getMessage();
    }
}

function delete($id) {

}

function update($id) {

}