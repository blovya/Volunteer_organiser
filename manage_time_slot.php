<?php
    require 'db_connect.php';
    if(!$_SESSION['email'])
	{
		header("Location:index.php");
		exit;
	}
    //If add is clicked.
    if (isset($_POST['add_time_slot']))
        {
            $stmt1=$db->prepare("SELECT * FROM volunteer_time_slot WHERE time_slot_id=? AND email=?");
            $stmt1->execute( [$_POST['time_slot_id'], $_SESSION['email']] );
            $check=$stmt1->fetch();
            if ($check)
                echo '<p><em>This time slot has been added already.</em></p>';
            else
            {
                $stmt=$db->prepare("INSERT INTO volunteer_time_slot(email, time_slot_id) VALUES (?, ?)");
                $result=$stmt->execute( [$_SESSION['email'], $_POST['time_slot_id']] );
                if ($result) 
                {
                    $stmt=$db->prepare("SELECT * FROM time_slot WHERE time_slot_id=?");
                    $stmt->execute([$_POST['time_slot_id']]);
                    $data=$stmt->fetch();
                    log_event('Time Slot Added', ''.$_SESSION['email'].' added '.$data['time_slot_name'].'');
                    header("Location:manage_time_slot.php");
                }
                else
                    echo '<p>No</p>';
            }
        }
    //If Remove is clicked.
    if (isset($_GET['id']))
    {
        $stmt=$db->prepare("DELETE FROM volunteer_time_slot WHERE email=? AND time_slot_id=?");
        $result=$stmt->execute([$_SESSION['email'], $_GET['id']] );
        if ($result)
        {
            $stmt=$db->prepare("SELECT * FROM time_slot WHERE time_slot_id=?");
            $stmt->execute([$_GET['id']]);
            $data=$stmt->fetch();
            log_event('Time Slot Removed', ''.$_SESSION['email'].' removed '.$data['time_slot_name'].'');
            //$log_stmt = $db->prepare("INSERT INTO log (ip_address, event_type, event_details) VALUES (?,?,?)");
            //$log_stmt->execute([$_SERVER['REMOTE_ADDR'], 'Remove Time Slot', 'email: '.$_POST['email']]);
            header('Location:manage_time_slot.php');
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title> Manage Time Slots</title>
        <style>
            table {border-collapse:collapse;}
            td, th {border: 1px solid black; width:200px; padding: 5px;}
            </style>
    </head>
    <body>
        <h1>Welcome, <?= $_SESSION['first_name']?></h1>
        <h3>Your Time Slots:</h3>
        <table>
            <tr>
                <th>Time Slot</th>
                <th>Allocated Task</th>
                <th>Details</th>
                <th>Remove</th>
            </tr>
            <?php
            $stmt=$db->prepare("SELECT * FROM time_slot 
                                RIGHT OUTER JOIN volunteer_time_slot ON time_slot.time_slot_id=volunteer_time_slot.time_slot_id
                                LEFT OUTER JOIN task ON task.task_id=volunteer_time_slot.task_id
                                WHERE email=? 
                                ORDER BY time_slot.time_slot_id");
            $stmt->execute([$_SESSION['email']]);

            $data=$stmt->fetchAll();
            if (count($data)>0)
            {
            foreach($data as $row)
            {
                $task_name=$row['task_name'] == NULL ? '<em>No Task Allocated!</em>' : $row['task_name'];
                echo '<tr>
                        <td>'.$row['time_slot_name'].'</td>
                        <td>'.$task_name.'</td>
                        <td>'.$row['details'].'</td>
                        <td><a href="manage_time_slot.php?id='.$row['time_slot_id'].'" onclick="return confirm(\'Are you sure?\')">Remove</a></td>
                    </tr>';
            }
            }
            else
                echo '<tr><td colspan="5"><em>You have not added any available time slots.</em></td></tr>';
            ?>
            </table>
            <form name="time_slot_form" method="post" action="manage_time_slot.php">
            <h3>Add Time Slot:</h3>
            <select name="time_slot_id" required>
            <option value="" selected disabled >Select a time slot...</option>
            <?php  
            // Select details of all forums
                $result = $db->query("SELECT * FROM time_slot ORDER BY time_slot_id ");
                // Loop through each forum to generate an option of the drop-down list
                foreach($result as $row)
                {
                    echo '<option value="'.$row['time_slot_id'].'">'.$row['time_slot_name'].'</option>';
                }
            ?>

            </select>
            <input type="submit" name="add_time_slot" value="Add" />
        </form>
        <br><a href="logout.php">Log Out!</a>
        
</body>
</html>

