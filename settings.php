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

<form method="POST" action="listController.php">
    <input type="text" name="title" id="title" value="<?php echo $task["title"] ?>">
    <input type="submit" value="Update">
</form>