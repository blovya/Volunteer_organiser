<?php
    require 'db_connect.php';
    if (isset($_POST['organiser_login']))
    {
        $stmt=$db->prepare("SELECT * FROM organiser WHERE username=? AND password=?");
        $stmt->execute( [$_POST['username'], $_POST['password']] );
        $user=$stmt->fetch();
        if ($user)
        {
            $_SESSION['username']=$user['username'];
            header('Location: volunteer_time_slot.php');
            exit;
        }
        else
        {
            echo 'Invalid credentials. Try again.';
        }
    }
    else
        echo '<p>Please submit the <a href="Organiser_login.php">form</a> first.</p>';
    ?>