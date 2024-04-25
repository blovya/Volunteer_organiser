<?php
    require 'db_connect.php';
    if (isset($_POST['volunteer_login']))
    {
        $stmt=$db->prepare("SELECT * FROM volunteer WHERE email=? AND password=?");
        $stmt->execute( [$_POST['email'], $_POST['password']] );
        $user=$stmt->fetch();
        if ($user)
        {
            $_SESSION['email']=$user['email'];
            $_SESSION['first_name']=$user['first_name'];
            header('Location: manage_time_slot.php');
            exit;
        }
        else
        {
            echo 'Invalid credentials. Try again.';
        }
    }
    else
        echo '<p>Please submit the <a href="login_form.php">form</a> first.</p>';
?>

       


