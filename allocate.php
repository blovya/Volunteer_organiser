<?php
    require 'db_connect.php';
    if(!$_SESSION['username'])
	{
		header("Location:index.php");
		exit;
	}
    if (isset($_POST['allocate']))
    {
        $stmt2=$db->prepare("SELECT * FROM task WHERE task_id=?");
        $stmt2->execute([$_POST['task_id']]);
        $data2=$stmt2->fetch();
        if ($data2['eighteen_plus']=='1')
        {
            $stmt_dob=$db->prepare("SELECT date_of_birth, volunteer_time_slot.email FROM volunteer_time_slot 
                                LEFT JOIN volunteer
                                ON volunteer_time_slot.email=volunteer.email
                                WHERE volunteer_time_slot_id=?");
            $stmt_dob->execute([$_POST['volunteer_slot_id']]);
            $data_dob=$stmt_dob->fetch();
            if (strtotime($data_dob['date_of_birth']) < strtotime('-18 years'))
            {
                $stmt=$db->prepare("UPDATE volunteer_time_slot
                                    SET task_id=?, details=?
                                    WHERE Volunteer_time_slot_ID=?");
                $result=$stmt->execute([$_POST['task_id'], $_POST['details'],
                                        $_POST['volunteer_slot_id']]);
            }
            else
            {
                echo 'Cannot allocate task because it is 18+ task.';
                echo '<br><br><input type="button" value="Go Back" onclick="history.back()" />';
                exit;
            }
        }
        else
        {
            $stmt=$db->prepare("UPDATE volunteer_time_slot
                                SET task_id=?, details=?
                                WHERE Volunteer_time_slot_ID=?");
            $result=$stmt->execute([$_POST['task_id'], $_POST['details'],
                                    $_POST['volunteer_slot_id']]);
        }

        /*
        $stmt=$db->prepare("UPDATE volunteer_time_slot
                            SET task_id=?, details=?
                            WHERE Volunteer_time_slot_ID=?");
        $result=$stmt->execute([$_POST['task_id'], $_POST['details'],
                                $_POST['volunteer_slot_id']]);
        */
        if ($result)
        {
            $stmt1=$db->prepare("SELECT * FROM volunteer_time_slot 
                                LEFT JOIN task
                                ON volunteer_time_slot.task_id=task.task_id
                                LEFT JOIN time_slot 
                                ON volunteer_time_slot.time_slot_id=time_slot.time_slot_id
                                WHERE volunteer_time_slot_id=?");
            $stmt1->execute([$_POST['volunteer_slot_id']]);
            $data=$stmt1->fetch();
            log_event('Allocate Task', ''.$_SESSION['username'].' allocated '.$data['task_name'].' to '.$data['email'].' on '.$data['time_slot_name'].'');
            header('Location:volunteer_time_slot.php');

        }
    }
    else 
        echo 'submit the form first';
        
?>

