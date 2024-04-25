<?php
    require 'db_connect.php';
    if(!$_SESSION['username'])
	{
		header("Location:index.php");
		exit;
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
        <h1>Volunteer Time Slot</h1>
        <table>
            <tr>
                <th>Time Slot</th>
                <th>Volunteer Name</th>
                <th> Allocated Task</th>
                <th>Details</th>
                <th>Edit</th>
            </tr>
            <?php
            $stmt=$db->prepare("SELECT vts.Volunteer_time_slot_ID, details, CONCAT(v.first_name, '  ', v.last_name) AS name, time_slot_name, task_name
                                FROM volunteer_time_slot AS vts 
                                INNER JOIN volunteer AS v ON vts.email=v.email
                                INNER JOIN time_slot AS ts ON vts.time_slot_id=ts.time_slot_id
                                LEFT OUTER JOIN task AS t ON vts.task_id=t.task_id
                                ORDER BY vts.time_slot_id ASC ");
            $stmt->execute();
            $data=$stmt->fetchAll();
            if (count($data)>0)
            {
            foreach($data as $row)
            {
                $task_name=$row['task_name'] == NULL ? '<em>No Task Allocated!</em>' : $row['task_name'];
                echo '<tr>
                        <td>'.$row['time_slot_name'].'</td>
                        <td>'.$row['name'].'</td>
                        <td>'.$task_name.'</td>
                        <td>'.$row['details'].'</td>
                        <td><a href="allocate_task.php?id='.$row['Volunteer_time_slot_ID'].'&vol_name='.$row['name'].'&slot_name='.$row['time_slot_name'].'">Edit</a></td>
                    </tr>';
            }
            }
            else
                echo '<tr><td colspan="5">No volunteer time slots found.</td></tr>';
            ?>
        </table>
        <p><a href="manage_tasks.php">Manage Tasks here!</a> | <a href="change_duration.php">Change Duration here!</a> 
        | <a href="view_log.php">View Logs here!</a> | <a href="logout.php">Log Out!</a></p>

</body> 
</html>

