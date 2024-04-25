<?php
    require 'db_connect.php';
    if(!$_SESSION['username'])
	{
		header("Location:index.php");
		exit;
	}
    //Get task id.
    if (isset($_GET['id']))
    {
        $stmt=$db->prepare("SELECT * FROM task WHERE task_id=?");
        $stmt->execute([$_GET['id']]);
        $task_data=$stmt->fetch();

        echo ' <form name=edit_task method=post action="edit_processing.php">
            <input type="hidden" name="task_name" value="'.$_GET['id'].' ?>"/>
            <h3>Editing Task Name</h3>
            <label>Edited Name:<input type="text" name="edited_name" maxlength="30" value="'.$task_data['task_name'].'" required /></label>
            <input type="submit" name="edit_task" value="Save changes"/>
    </form>';
    }
    else
        echo 'Please click on edit first.';
    
echo '<a href="manage_tasks.php">Go Back!</a>';   
?>
   