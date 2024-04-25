<?php
    require 'db_connect.php';
    if(!$_SESSION['username'])
	{
		header("Location:index.php");
		exit;
	}
    //Deleting the task.
    if (isset($_GET['id']))
    {
        $stmt1=$db->prepare("SELECT * FROM volunteer_time_slot WHERE task_id=? ");
        $stmt1->execute( [$_GET['id']] );
        $check=$stmt1->fetch();
        if ($check)
            { 
                echo '<h3>Error</h3>';
                echo '<em>Task cannot be deleted since it has been assigned to a volunter.</em>';
                echo '<br><br><a href="manage_tasks.php">Go Back.</a>'; 
                exit;
            }
        else
        {
            $stmt2=$db->prepare("SELECT * FROM task WHERE task_id=? ");
            $stmt2->execute( [$_GET['id']] );
            $data=$stmt2->fetch();
            $stmt=$db->prepare("DELETE FROM task WHERE task_id=?");
            $result=$stmt->execute([$_GET['id']] );
            log_event('Delete Task', ''.$_SESSION['username'].' deleted task "'.$data['task_name'].'"');
            header('Location:manage_tasks.php');
        }
    }
    
?>
<!DOCTYPE html>
<html>
    <head>
    <title> Volunteer Time Slots</title>
        <style>
            table {border-collapse:collapse;}
            td, th {border: 1px solid black; width:200px; padding: 5px;}
            </style>
    </head>
    <body>
        
            <h3>Current Tasks:</h3>
        <table>
            <tr>
                <th>Task Name</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <?php
            $stmt=$db->prepare("SELECT * FROM task ORDER BY task_id ASC");
            $stmt->execute();
            $data=$stmt->fetchAll();
            if (count($data)>0)
            {
            foreach($data as $row)
            {
                $task_name=$row['eighteen_plus'] == '1' ? ''.$row['task_name'].' (18+)'  : $row['task_name'];
                echo '<tr>
                        <td>'.$task_name.'</td>
                        <td><a href="edit_task.php?id='.$row['task_id'].'">Edit</a></td>
                        <td><a href="manage_tasks.php?id='.$row['task_id'].'" onclick="return confirm(\'Are you sure?\')">Delete</a></td>
                    </tr>';
            }
            }
            else
                echo '<tr><td colspan="5">No tasks added yet.</td></tr>';
            ?>
            </table>
            <form name="add_new_task" method="post" action="add_task.php">
            <h2>Add New Tasks</h2>
            <label>Task Name: <input type="text" name="new_task" maxlength="20" placeholder="Task Name..." required /></label>
            <label><input type="checkbox" name="18+" />18+ </label>
            <input type="submit" name="add_task" value="Add" />
            <p><a href="volunteer_time_slot.php">Go to Volunteer time slots page.</a></p>
            
        </form>
    </body>
</html>

