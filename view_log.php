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
        <title>View Log</title>
        <style>
            table {border-collapse:collapse;}
            td, th {border: 1px solid black; padding: 5px;}
        </style>
    </head>
    <body>
        <h2>Event Log:</h2>
        <table>
            <tr>
                <th>Log Date</th>
                <th>IP Address</th>
                <th>Event Type</th>
                <th>Event Details</th>
            </tr>
            <?php
            $stmt=$db->prepare("SELECT log_date, ip_address, event_type, event_details FROM log 
                                ORDER BY log_date DESC ");
            $stmt->execute();
            $data=$stmt->fetchAll();
            if (count($data)>0)
            {
            foreach($data as $row)
            {
                echo '<tr>
                        <td>'.$row['log_date'].'</td>
                        <td>'.$row['ip_address'].'</td>
                        <td>'.$row['event_type'].'</td>
                        <td>'.$row['event_details'].'</td>
                    </tr>';
            }
            }
            else
                echo '<tr><td colspan="5">No data logged yet.</td></tr>';
            ?>
        </table>
        <p><a href="volunteer_time_slot.php">Manage Volunteer Time Slots!</a></p></b>
        <a href="logout.php">Log Out!</a>
</body> 
</html>

