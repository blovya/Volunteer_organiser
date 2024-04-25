<?php
    require 'db_connect.php';
    if (isset($_POST['organiser_login']))
    {
        $stmt=$db->prepare("SELECT * FROM organiser WHERE username=?");
        $stmt->execute( [$_POST['username']] );
        $user=$stmt->fetch();
        if ($user && password_verify($_POST['password'], $user['password_hash']))
        {
            $_SESSION['username']=$user['username'];
            header('Location: volunteer_time_slot.php');
            log_event('Login (Organiser)', ''.$_POST['username'].' logged in');
            exit;
        }
        else
        {
            log_event('Failed Login (Organiser)', ''.$_POST['username'].' failed to log in');
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
    <form name="loginForm" method="post" action="Organiser_login.php">
        <h3> Organiser Login </h3>
        <label><span>Username:<sup>*</sup></span><input type="text" name="username" maxlength="30" placeholder="Username..." required /></label><br>
        <br><label><span>Password:<sup>*</sup></span><input type="password" name="password" maxlength="30" placeholder="Password..." required/></label><br>
        <br><input type="submit" name="organiser_login" value="Login" />
    </form>
</body>
</html>