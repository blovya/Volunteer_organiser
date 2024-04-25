<?php
    require 'db_connect.php';
    if(!$_SESSION['username'])
	{
		header("Location:index.php");
		exit;
	}

    if (isset($_POST['duration']))
    {
        $stmt=$db->prepare("SELECT * FROM time_slot");
        $stmt->execute();
        $data=$stmt->fetchall();
        $old_slots=count($data);
        $new_slots=$_POST['duration']*3;
        $a=$old_slots+1;
        $old_duration=$old_slots/3;
        if (intval($_POST['duration'])>$old_duration)
        {
            $time=['Morning','Afternoon','Night'];
            $stmt2=$db->prepare("INSERT INTO time_slot(time_slot_id, time_slot_name) VALUES(?,?)");
            for ($i=$old_duration+1; $i<=$_POST['duration']; $i++ )
            {
                foreach($time as $time_slot)
                {
                    $result=$stmt2->execute([$a, "Day $i, $time_slot"]);
                    $a++;
                }
            }
            log_event('Increased Duration', ''.$_SESSION['username'].' increased duration to '.$_POST['duration'].' days.');
        }
        else if (intval($_POST['duration'])<$old_duration)
        {
            $stmt=$db->prepare("DELETE FROM time_slot WHERE time_slot_id>?");
            $result=$stmt->execute([$new_slots] );
            if ($result)
            {
                log_event('Decreased Duration', ''.$_SESSION['username'].' decreased duration to '.$_POST['duration'].' days.');
                echo 'Duration has been updated.';    
            }
        }
        else
        echo 'New duration entered is same as old duration.'; 
        
    }
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="form_format.css" />
</head>
<body>
    <form method="post" action="change_duration.php">
        <h2> Change Duration </h2>
        Change Duration: <select name="duration" required>
            <option value="" selected disabled >Select the duration...</option>
            <?php 
                $stmt=$db->prepare("SELECT * FROM time_slot");
                $stmt->execute();
                $data=$stmt->fetchall();
                $result=[1,2,3,4,5,6,7];
                $days=count($data)/3;
                foreach($result as $row)
                {
                    if ($row==$days)
                    echo '<option value="'.$row.'" selected >'.$row.'</option>';
                    else
                    echo '<option value="'.$row.'" >'.$row.'</option>';
                }
            ?>
            </select>
        <br><br><input type="submit" name="change_duration" />
        <p><a href="volunteer_time_slot.php">Go to Volunteer Time Slots page!</a></p></b>
    </form>
</body>
</html>