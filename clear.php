<?php
    require 'db_connect.php';
    if(!$_SESSION['username'])
	{
		header("Location:index.php");
		exit;
	}
        $stmt=$db->prepare("SELECT * FROM volunteer_time_slot 
                            LEFT JOIN task
                            ON volunteer_time_slot.task_id=task.task_id
                            LEFT JOIN time_slot 
                            ON volunteer_time_slot.time_slot_id=time_slot.time_slot_id
                            WHERE volunteer_time_slot_id=?");
        $stmt->execute([$_GET['id']]);
        $data=$stmt->fetch();
        if (isset($_GET['id']))
        {
            $stmt=$db->prepare("UPDATE volunteer_time_slot SET details=NULL, task_id=NULL WHERE Volunteer_time_slot_ID=?");
            $result=$stmt->execute([$_GET['id']] );
            if ($result)
            {
                log_event('Clearing Time Slot', ''.$_SESSION['username'].' cleared '.$data['task_name'].' allocated to '.$data['email'].' on '.$data['time_slot_name'].'');
                header("Location:volunteer_time_slot.php");
            }
            else
            {
                echo '<p>Task did not delete.</p>';
            }
        }
        else
        {
            echo 'Please click on clear first.';
        }
      
      
?>