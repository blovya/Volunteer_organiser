<?php
    require 'db_connect.php';
    if (isset($_POST['register']))
    {
        /*$stmt=$db->prepare("INSERT INTO volunteer (email, password, first_name, last_name, phone_number, postcode) VALUES (?,?,?,?,?,?)");
        $result=$stmt->execute( [$_POST['email'], $_POST['password'], $_POST['first_name'], $_POST['last_name'], $_POST['phone_number'], $_POST['postcode']] );

        if ($result)
        {   */
            $errors = [];
            
            // The following "if" statements validate the form data
            // By using separate "if" statements, we always check all of the fields,
            // rather than stopping after finding a single error
            
            // Tests if the username field is empty
            if ($_POST['email'] == '')
            {
                $errors[] = 'Username is empty.';
            }
            
            // Tests if the password field is less than 6 characters long
            if (strlen($_POST['password']) < 5)
            {
                $errors[] = 'Password must be at least 6 characters long.';
            }
            
            // Tests if the password and password confirmation fields do not match
            if ($_POST['password'] != $_POST['confirmpass'])
            {
                $errors[] = 'Password does not match confirmation.';
            }
            
            // Tests if the postcode is not made up of digits or not 4 characters long
            if (!ctype_digit($_POST['postcode']) || strlen($_POST['postcode']) != 4) 
            {
                $errors[] = 'Postcode must be a 4 digit number.';
            }
            
            // If the error message array contains any items, it evaluates to True
            if ($errors)
            { // Display all error messages and link back to form
                foreach ($errors as $error)
                {
                echo '<p>'.$error.'</p>';
                }
            
                echo '<a href="javascript: window.history.back()">Return to form</a>';
            }
            else
            { 
                $hash=password_hash($_POST['password'], PASSWORD_DEFAULT);
                // Validation successful (code to process the data would go here)
                $stmt=$db->prepare("INSERT INTO volunteer (email, password_hash, first_name, last_name, date_of_birth, phone_number, postcode) VALUES (?,?,?,?,?,?,?)");
                $result=$stmt->execute( [$_POST['email'], $hash, $_POST['first_name'], $_POST['last_name'], $_POST['dob'], $_POST['phone_number'], $_POST['postcode']] );

                if ($result)
                { 
                        echo '<p>Registration complete!</p>';
                        echo '<p><a href="login_form.php">Log In</a></p>';
                        log_event('Registration (Volunteer)', ''.$_POST['email'].' registered');
                }
    
                else if ($stmt->errorCode()=='23000')
                {
                    echo '<p>Username of "'.$_POST['email'] .'" already exists. Try using a different username.</p>';
                    echo '<p><a href="javascript: history.back()">Return to Register<a/></p>';
                    echo '<a href="login_form.php">Log In<a/> instead';
                }
            }
    }
    else
        { // Show message if the form has not been submitted
        echo 'Please submit the <a href="Registration_form.php">form</a>.';
        }
?>
    
