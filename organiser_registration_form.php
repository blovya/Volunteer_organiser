<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="form_format.css" />
<script>
        function validateForm() {
            var form = document.orgregform;
            if (form.password.value.length < 5) {
                alert('Password is too short.');
                event.preventDefault()
            }
            if (form.password.value!=form.confirmpass.value) {
                alert("Password does not match confirmation.")
                event.preventDefault()
            }
            return true;
        }
    </script>
</head>
<body>
    <form name="orgregform" method="post" action="organiser_registration.php" onsubmit="return validateForm()">
        <h3>Organiser Registration:</h3>
        <label><span><b>ACCESS CODE:</b><sup>*</sup></span><input type="password" name="code" maxlength="30" required /></label><br>
        <label><span>Username:<sup>*</sup></span><input type="text" name="username" maxlength="30" placeholder="Username..." required /></label><br>
        <label><span>Password:<sup>*</sup></span><input type="password" name="password" maxlength="30" minlength="5" placeholder="Password..." required /></label><br>
        <label><span>Confirm Password:<sup>*</sup></span><input type="password" name="confirmpass" maxlength="30" placeholder="Confirm Password..." required/></label><br>
        <input type="submit" name="register" value="Register"/>
        <input type="button" value="Back" onclick="history.back()"/>
    </form>
</body>
</html>