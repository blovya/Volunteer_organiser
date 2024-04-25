<?php
    require 'db_connect.php';
    if (isset($_POST['register']))
    {
            $errors = [];
            
            //Tests for ACCESS CODE.
            if ($_POST['code']!="CSG2431")
            {
                $errors[] = 'Wrong Access Code.';
            }

            // Tests if the username field is empty
            if ($_POST['username'] == '')
            {
                $errors[] = 'Username is empty.';
            }
            
            // Tests if the password field is less than 6 characters long
            if (strlen($_POST['password']) < 5)
            {
                $errors[] = 'Password must be at least 5 characters long.';
            }
            
            // Tests if the password and password confirmation fields do not match
            if ($_POST['password'] != $_POST['confirmpass'])
            {
                $errors[] = 'Password does not match confirmation.';
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
                $stmt=$db->prepare("INSERT INTO organiser (username, password_hash) VALUES (?,?)");
                $result=$stmt->execute( [$_POST['username'], $hash,] );

                if ($result)
                { 
                        echo '<p>Registration complete!</p>';
                        echo '<p><a href="Organiser_login.php">Log In</a></p>';
                        log_event('Registration (Organiser)', ''.$_POST['username'].' registered');
                }
    
                else if ($stmt->errorCode()=='23000')
                {
                    echo '<p>Username of "'.$_POST['username'] .'" already exists. Try using a different username.</p>';
                    echo '<p><a href="javascript: history.back()">Return to Register<a/></p>';
                }
            }
    }
    else
        { // Show message if the form has not been submitted
        echo 'Please submit the <a href="organiser_registration_form.php">form</a>.';
        }
?>