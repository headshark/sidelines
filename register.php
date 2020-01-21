<?php
    if (isset($_POST["submitButton"])) {
        echo "Form was submitted";
    }
?>
<!DOCTYPE html>
<html>
    <head>
	    <link rel="stylesheet" type="text/css" href="css/style.css">
        <title>Sidelines - Watch Basketball Highlights</title>
    </head>
    <body>
        <div class="sign-up-container">
            <div class="column">
                <div class="header">
                    <img src="images/logo.png" alt="Site Logo" />
                    <h3>Sign Up</h3>
                    <span>to continue to Sidelines</span>
                </div>

                <form method="POST">
                    <input type="text" name="firstName" placeholder="First name" required>
                    <input type="text" name="lastName" placeholder="Last name" required>
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="email" name="emailConfirm" placeholder="Confirm email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="password" name="passwordConfirm" placeholder="Confirm password" required>
                    <input type="submit" name="submitButton" value="Submit">
                </form>

                <a href="login.php" class="sign-in-message">Already have an account? Sign in here!</a>
            </div>
        </div>
    </body>
</html>