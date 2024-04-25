<?php
    require 'db_connect.php';
    
    //to prevent access.
    if(!$_SESSION['username'])
	{
		header("Location:index.php");
		exit;
	}

    //is user is trying to edit task.
    if (isset($_POST['edit_task']))
    { 
         // The input contains at least one non-space character
        if (strlen(trim($_POST['edited_name'])) == 0) 
        {
            echo '<h3>Error</h3>';
            echo '<em>The task name cannot be empty.</em>';
            echo '<br><br><a href="manage_tasks.php">Go Back.</a>'; 
            exit;
        }
        else
        {   
            $stmt1=$db->prepare("SELECT * FROM task WHERE task_id=? ");
            $stmt1->execute( [$_POST['task_name']] );
            $data_before=$stmt1->fetch();
            $stmt = $db->prepare("UPDATE task SET task_name = ? WHERE task_id = ?");
            $result = $stmt->execute([$_POST['edited_name'], $_POST['task_name']]);
            $stmt2=$db->prepare("SELECT * FROM task WHERE task_id=? ");
            $stmt2->execute( [$_POST['task_name']] );
            $data_after=$stmt2->fetch();
            if ($result)
            {
                log_event('Edit Task', ''.$_SESSION['username'].' edited task "'.$data_before['task_name'].'" as "'.$data_after['task_name'].'"');
                header('Location:manage_tasks.php');
            }
            else
            {
                echo '<h3>Error</h3>';
                echo '<em>Two tasks cannot have same name.</em>';
                echo '<br><br><a href="manage_tasks.php">Go Back.</a>'; 
                exit;
            }
        }
    }
    else
        echo 'Please submit the form first.'; 
?>
   