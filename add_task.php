<?php
    require 'db_connect.php';
    //To prevent access.
    if(!$_SESSION['username'])
	{
		header("Location:index.php");
		exit;
	}

    //If user is trying to add a task
    if (isset($_POST['add_task']))
    {
    $stmt1=$db->prepare("SELECT * FROM task WHERE task_name=? ");
    $stmt1->execute( [$_POST['new_task']] );
    $check=$stmt1->fetch();
    //if task name is already present.
    if ($check)
    {
        echo '<h3>Error</h3>';
        echo '<em>This task has been added already. Try adding another task.</em>';
        echo '<br><br><a href="manage_tasks.php">Go Back.</a>'; 
        exit;   
    }
    // The input contains at least one non-space character
    else if (strlen(trim($_POST['new_task'])) == 0) 
    {
        echo '<h3>Error</h3>';
        echo '<em>The task name cannot be empty.</em>';
        echo '<br><br><a href="manage_tasks.php">Go Back.</a>'; 
        exit;
    }
    else
    {
        if (isset($_POST['18+']))
        {
            $stmt=$db->prepare("INSERT INTO task(task_name, eighteen_plus) VALUES(?,?)");
            $stmt->execute( [$_POST['new_task'], '1'] );
        }
        else
        {
            $stmt=$db->prepare("INSERT INTO task(task_name) VALUES(?)");
            $stmt->execute( [$_POST['new_task']] );   
        }
        $stmt2=$db->prepare("SELECT * FROM task WHERE task_name=? ");
        $stmt2->execute( [$_POST['new_task']] );
        $data=$stmt2->fetch();
        log_event('Add Task', ''.$_SESSION['username'].' added task "'.$data['task_name'].'"');
        header('Location:manage_tasks.php');
    }
    }
    else
    {
        echo 'Please submit the form first.';
    }

    
?>
   