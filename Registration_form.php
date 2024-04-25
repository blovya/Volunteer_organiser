<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="form_format.css" />
    <script>
        function validateForm() {
            var form = document.regform;
            if (form.password.value.length < 5) {
                alert('Password is too short.');
                event.preventDefault()
            }
            if (form.password.value!=form.confirmpass.value) {
                alert("Password does not match confirmation.")
                event.preventDefault()
            }
            if (isNaN(form.postcode.value)) {
                alert("Postcode needs to be a 4-digit number.")
                event.preventDefault()
            }
            return true;
        }
    </script>

</head>
<body>
    <form name="regform" method="post" action="index.php" onsubmit="return validateForm()">
        <h3> Registration Page </h3>
        <label><span>Email Address:<sup>*</sup></span><input type="email" name="username" maxlength="30" placeholder="Username..." required /></label><br>
        <label><span>Password:<sup>*</sup></span><input type="password" name="password" maxlength="30" minlength="5" placeholder="Password..." required /></label><br>
        <label><span>Confirm Password:<sup>*</sup></span><input type="password" name="confirmpass" maxlength="30" placeholder="Confirm Password..." required/></label><br>
        <label><span>First Name:<sup>*</sup></span><input type="text" name="first_name" maxlength="30" placeholder="First Name..." required/></label><br>
        <label><span>Last Name:<sup>*</sup></span><input type="text" name="last_name" maxlength="30" placeholder="Last Name..." required/></label><br>
        <label><span>Phone Number:<sup>*</sup></span><input type="phone number" name="phone_number" maxlength="25" placeholder="Phone Number..." required/></label><br>
        <label><span>Postcode:<sup>*</sup></span><input type="postcode" name="postcode" maxlength="4" minlength="4" placeholder="Postcode..." required/></label><br>
        <input type="submit" name="register" value="Register"/>
        <input type="button" value="Back" onclick="history.back()" />

    </form>
</body>
</html>