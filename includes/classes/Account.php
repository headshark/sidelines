<?php
class Account
{
    private $conn;
    private $errorArray = array();

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updateDetails($firstName, $lastName, $email, $username) {
        $this->validateFirstName($firstName);
        $this->validateLastName($lastName);
        $this->validateNewEmail($email, $username);

        if (empty($this->errorArray)) {
            $query = $this->conn->prepare("UPDATE users SET first_name=:firstName, last_name=:lastName, email=:email
                                    WHERE username=:username");
            $query->bindValue(":firstName", $firstName);
            $query->bindValue(":lastName", $lastName);
            $query->bindValue(":email", $email);
            $query->bindValue(":username", $username);
            
            return $query->execute();
        }

        return false;
    }

    public function register($firstName, $lastName, $username, $email, $confirmEmail, $password, $confirmPassword) {
        $this->validateFirstName($firstName);
        $this->validateLastName($lastName);
        $this->validateUsername($username);
        $this->validateEmails($email, $confirmEmail);
        $this->validatePasswords($password, $confirmPassword);

        if (empty($this->errorArray)) {
            return $this->insertUserDetails($firstName, $lastName, $username, $email, $password);
        }

        return false;
    }

    public function login($username, $password) {
        $password = hash("sha512", $password);

        $query = $this->conn->prepare("SELECT * FROM users WHERE username=:username AND password=:password");
        $query->bindValue(":username", $username);
        $query->bindValue(":password", $password);

        $query->execute();

        if ($query->rowCount() == 1) {
            return true;
        }

        array_push($this->errorArray, Constants::$loginFailed);
        return false;
    }

    private function insertUserDetails($firstName, $lastName, $username, $email, $password) {
        $password = hash("sha512", $password);

        $query = $this->conn->prepare("INSERT INTO users (first_name, last_name, username, email, password)
            VALUES (:firstName, :lastName, :username, :email, :password)");
        $query->bindValue(":firstName", $firstName);
        $query->bindValue(":lastName", $lastName);
        $query->bindValue(":username", $username);
        $query->bindValue(":email", $email);
        $query->bindValue(":password", $password);

        return $query->execute();
    }

    private function validateFirstName($firstName) {
        if (strlen($firstName) < 2 || strlen($firstName) > 25) {
            array_push($this->errorArray, Constants::$firstNameCharacters);
        }
    }

    private function validateLastName($lastName) {
        if (strlen($lastName) < 2 || strlen($lastName) > 25) {
            array_push($this->errorArray, Constants::$lastNameCharacters);
        }
    }

    private function validateUsername($username) {
        if (strlen($username) < 2 || strlen($username) > 25) {
            array_push($this->errorArray, Constants::$usernameCharacters);
            return;
        }

        $query = $this->conn->prepare("SELECT * FROM users WHERE username=:username");
        $query->bindValue(":username", $username);
        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$usernameTaken);
        }
    }

    private function validateEmails($email, $confirmEmail) {
        if ($email != $confirmEmail) {
            array_push($this->errorArray, Constants::$emailsDontMatch);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }

        $query = $this->conn->prepare("SELECT * FROM users WHERE email=:email");
        $query->bindValue(":email", $email);
        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$emailTaken);
        }
    }

    private function validateNewEmail($email, $username) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }

        $query = $this->conn->prepare("SELECT * FROM users WHERE email=:email AND username != :username");
        $query->bindValue(":email", $email);
        $query->bindValue(":username", $username);
        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$emailTaken);
        }
    }

    private function validatePasswords($password, $confirmPassword) {
        if ($password != $confirmPassword) {
            array_push($this->errorArray, Constants::$passwordsDontMatch);
            return;
        }
        
        if (strlen($password) < 5 || strlen($password) > 25) {
            array_push($this->errorArray, Constants::$passwordLength);
        }
    }

    public function getError($error) {
        if (in_array($error, $this->errorArray)) {
            return "<span class='errorMessage'>$error</span>";
        }
    }

    public function getFirstError() {
        if (!empty($this->errorArray)) {
            return $this->errorArray[0];
        }
    }

    public function updatePassword($oldPassword, $password, $confirmPassword, $username) {
        $this->validateOldPassword($oldPassword, $username);
        $this->validatePasswords($password, $confirmPassword);

        if (empty($this->errorArray)) {
            $query = $this->conn->prepare("UPDATE users SET password=:password WHERE username=:username");
            $password = hash("sha512", $password);
            $query->bindValue(":password", $password);
            $query->bindValue(":username", $username);
            
            return $query->execute();
        }

        return false;
    }

    public function validateOldPassword($oldPassword, $username) {
        $password = hash("sha512", $oldPassword);

        $query = $this->conn->prepare("SELECT * FROM users WHERE username=:username AND password=:password");
        $query->bindValue(":username", $username);
        $query->bindValue(":password", $password);

        $query->execute();

        if ($query->rowCount() == 0) {
            array_push($this->errorArray, Constants::$passwordIncorrect);
        }
    }
}
?>