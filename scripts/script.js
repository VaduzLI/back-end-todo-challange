const openTaskList = (id) => {
    let taskItem = document.getElementById("taskItem" + id);
    if(taskItem.style.display == "block") {
        taskItem.style.display = "none"
    } else {
        taskItem.style.display = "block"
    }
}