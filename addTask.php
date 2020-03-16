<html>
    <head>
        <link rel="stylesheet" href="styles/styles.css" type="text/css">
    </head>
    <body>
        <div class="addTaskBackground">
            <form class="createListForm" method="post" action="listController.php">
            <span class="addTaskHeader">Create New Tasklist</span>
                <input type="hidden" name="type" value="store">
                <input required placeholder="Title" class="listFormInput" name="title" type="text">
                <input class="listFormSubmit" type="submit">
            </form>
        </div>
    </body>
</html>