<?php
    require 'db_connect.php';
    if (isset($_POST['volunteer_login']))
    {
        $stmt=$db->prepare("SELECT * FROM volunteer WHERE email=?");
        $stmt->execute( [$_POST['email']]);
        $user=$stmt->fetch();
        if ($user && password_verify($_POST['password'], $user['password_hash']))
        {
            $_SESSION['email']=$user['email'];
            $_SESSION['first_name']=$user['first_name'];
            header('Location: manage_time_slot.php');
            log_event('Login (Volunteer)', ''.$_POST['email'].' logged in');
            exit;
        }
        else
        {
            log_event('Failed Login (Volunteer)', ''.$_POST['email'].' failed to log in');
            //$log_stmt = $db->prepare("INSERT INTO log (ip_address, event_type, event_details) VALUES (?,?,?)");
            //$log_stmt->execute([$_SERVER['REMOTE_ADDR'], 'Failed Volunteer Login', 'email: '.$_POST['email']]);
            echo 'Invalid credentials. Try again.';
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="form_format.css" />
</head>
<body>
    <form name="loginForm" method="post" action="login_form.php">
        <h3> Volunteer Login </h3>
        <label><span>Email Address:<sup>*</sup></span><input type="email" name="email" maxlength="30" placeholder="Username..." required/></label><br>
        <br><label><span>Password:<sup>*</sup></span><input type="password" name="password" maxlength="30" placeholder="Password..." required/></label><br>
        <b><p><a href="Registration_form.php">Register to Volunteer!</a></p></b>
        <input type="submit" name="volunteer_login" value="Login" />
        <input type="button" value="Back" onclick="history.back()"/>
    </form>
</body>
</html>
