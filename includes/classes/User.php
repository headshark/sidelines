<?php
class User
{
    private $conn, $sqlData;

    public function __construct($conn, $username) {
        $this->conn = $conn;

        $query = $conn->prepare("SELECT * FROM users WHERE username=:username");
        $query->bindValue(":username", $username);
        $query->execute();

        $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getFirstName() {
        return $this->sqlData["first_name"];
    }

    public function getLastName() {
        return $this->sqlData["last_name"];
    }
    
    public function getEmail() {
        return $this->sqlData["email"];
    }

    public function getUsername() {
        return $this->sqlData["username"];
    }

    public function getIsSubscribe() {
        return $this->sqlData["is_subscribed"];
    }

    public function setIsSubscribed($value) {
        $query = $this->conn->prepare("UPDATE users SET is_subscribed=:isSubscribed
                                    WHERE username=:username");
        $query->bindValue(":isSubscribed", $value);
        $query->bindValue(":username", $this->getUsername());

        if ($query->execute()) {
            $this->sqlData["is_subscribed"] = $value;
            return true;
        }

        return false;
    }
}
?>
