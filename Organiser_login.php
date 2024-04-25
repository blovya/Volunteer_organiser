<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="form_format.css" />
</head>
<body>
    <form name="loginForm" method="post" action="volunteer_time_slots.php">
        <h3> Organiser Login </h3>
        <label><span>Username:<sup>*</sup></span><input type="email" name="username" maxlength="30" placeholder="Username..." required /></label><br>
        <br><label><span>Password:<sup>*</sup></span><input type="password" name="password" maxlength="30" placeholder="Password..." required/></label><br>
        <br><input type="submit" name="login" value="Login" />
        <input type="button" value="Back" onclick="history.back()"/>
    </form>
</body>
</html>