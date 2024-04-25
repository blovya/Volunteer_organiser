<?php
    require 'db_connect.php';    
    if(!$_SESSION['username'])
	{
		header("Location:index.php");
		exit;
	}
    //To get the volunteer time slot selected.
    if (isset($_GET['id']))
    {
        $stmt=$db->prepare("SELECT details, task_id, Volunteer_time_slot_ID FROM volunteer_time_slot WHERE Volunteer_time_slot_ID=?");
        $stmt->execute([$_GET['id']]);
        $assigned_task=$stmt->fetch();

        echo ' <form name=allocate_task method=post action="allocate.php">
            <input type="hidden" name="volunteer_slot_id" value="'.$_GET['id'].' ?>"/>';
    }
    else
    {
        echo 'Please click on edit first.';
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Allocate Tasks</title>
</head>
<body>
            <form name="allocate_task" method="post" action="allocate.php">
            <h2>Volunteer: <?= $_GET['vol_name'] ?></h2>
            <h2>Time Available: <?= $_GET['slot_name'] ?></h2>
            <h3>Allocating Task</h3>
            <label>Details:<textarea name="details" style="width: 500px; height: 100px;"><?= $assigned_task['details'] ?></textarea></label>
            <p>Choose Task:
        <select name="task_id" required>
            <option value="" selected disabled>Select a task</option>
        <?php
        
                $result=$db->query("SELECT * FROM task ORDER BY task_id");

                foreach ($result as $row)
                {
                    $eighteen_plus=$row['eighteen_plus']==1 ? '(18+)' : '';
                    if ($assigned_task['task_id'] == NULL)
                        echo '<option value="'.$row['task_id'].'" >'.$row['task_name'].''. $eighteen_plus.'</option>';
                    else
                    {
                        $text=$row['task_id']==$assigned_task['task_id'] ? 'selected' : '';
                        echo '<option value="'.$row['task_id'].'"'.$text.' >'.$row['task_name'].''. $eighteen_plus.'</option>';
                    }
                }
                ?>
            </select>
            </p>
            <input type="submit" name="allocate" value="Allocate"/>
            <p>If you do not want to make changes, <a href="volunteer_time_slot.php">Go Back!</a></p>
    <?php
    echo '<a href="clear.php?id='.$assigned_task['Volunteer_time_slot_ID'].'" onclick="return confirm(\'Are you sure?\')">Clear</a>';
    ?>
    </form>
            </body>
            </html>
