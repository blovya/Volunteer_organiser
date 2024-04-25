<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="form_format.css" />
</head>
<body>
    <form name="loginForm" method="post" action="manage_time_slots.php">
        <h3> Volunteer Login </h3>
        <label><span>Email Address:<sup>*</sup></span><input type="email" name="username" maxlength="30" placeholder="Username..." required/></label><br>
        <br><label><span>Password:<sup>*</sup></span><input type="password" name="password" maxlength="30" placeholder="Password..." required/></label><br>
        <b><p><a href="Registration_form.php">Register to Volunteer!</a></p></b>
        <input type="submit" name="login" value="Login" />
        <input type="button" value="Back" onclick="history.back()"/>

    </form>
</body>
</html>
