<?php
require_once("includes/config.php");
require_once("includes/classes/FormSanitizer.php");

if (isset($_POST["submitButton"])) {
    $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
    $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);
    $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
    $confirmEmail = FormSanitizer::sanitizeFormEmail($_POST["confirmEmail"]);
    $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
    $confirmPassword = FormSanitizer::sanitizeFormPassword($_POST["confirmPassword"]);

    echo $firstName . "<br>";
    echo $lastName . "<br>";
    echo $email . "<br>";
    echo $confirmEmail . "<br>";
    echo $password . "<br>";
    echo $confirmPassword . "<br>";
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
                    <input type="email" name="confirmEmail" placeholder="Confirm email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="password" name="confirmPassword" placeholder="Confirm password" required>
                    <input type="submit" name="submitButton" value="Submit">
                </form>

                <a href="login.php" class="sign-in-message">Already have an account? Sign in here!</a>
            </div>
        </div>
    </body>
</html>