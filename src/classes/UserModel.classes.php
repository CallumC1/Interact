<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/databaseHandler.classes.php");


class UserModel extends databaseHandler {

    protected function insertUser($first_name, $last_name, $email, $password) {
        
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (user_first_name, user_last_name, user_email, user_password_hash) VALUES (?, ?, ?, ?)";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ssss", $first_name, $last_name, $email, $password_hash);

        if (!$stmt->execute()) {
            $stmt->close();
            echo("Error in insertUser statement.");
            die();
        }

        $stmt->close();
    }

    // Returns true if email already exists, false if not.
    protected function checkUserEmailExists($email) {
        $conn = $this->connect();
        $sql = "SELECT * FROM users WHERE user_email = ?";
        $stmt = $conn->prepare($sql);


        $stmt->bind_param("s", $email);

        if (!$stmt->execute()) {
            $stmt->close();
            echo("Error in checkUserEmailExists statement.");
            die();
        }

        $result = $stmt->get_result();
        $numRows = $result->num_rows;

        if ($numRows > 0) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }

    }


    protected function getUser($email, $password) {
        $conn = $this->connect();
        $sql = "SELECT * FROM users WHERE user_email = ?";
        $stmt = $conn->prepare($sql);


        $stmt->bind_param("s", $email);

        if (!$stmt->execute()) {
            $stmt->close();
            echo("Error in getUser statement.");
            die();
        }

        $result = $stmt->get_result();
        $numRows = $result->num_rows;

        if ($numRows == 0) {
            $stmt->close();
            echo("User does not exist!");
            exit();
        } 

        $row = $result->fetch_assoc();
        $stmt->close();

        $password_hashed = $row["user_password_hash"];
        $check_password = password_verify($password, $password_hashed);

        // Check if the given password matches the hashed password in the database.
        if($check_password == false) {
            echo("Incorrect Password");
            exit();
        } elseif ($check_password == true) {
            return $row;
        } else {
            echo("Error in getUser statement.");
            exit();
        }

    }

    public static function userByID($user_id) {
        $db = new databaseHandler();
        $conn = $db->connect();
        $sql = "SELECT user_email, user_first_name, user_last_name, user_about FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("i", $user_id);

        if (!$stmt->execute()) {
            $stmt->close();
            echo("Error in userByID statement.");
            die();
        }

        $result = $stmt->get_result()->fetch_assoc();
        
        return $result;
    }


    public static function userHasLiked($messageId, $userId) {
        $db = new databaseHandler();
        $conn = $db->connect();
        
        $sql = "SELECT * FROM likes WHERE message_id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
    
        $stmt->bind_param("ii", $messageId, $userId);
        $stmt->execute();
    
        $result = $stmt->get_result();
    
        $stmt->close();
    
        return $result->num_rows > 0; // true if user has liked, false if not
    }

    protected function updateUserBio($user_id, $bio_message){
        $conn = $this->connect();
        $sql = "UPDATE users SET user_about = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("si", $bio_message, $user_id);

        if (!$stmt->execute()) {
            $stmt->close();
            echo("Error in updateUserBio statement.");
            die();
        }

        $stmt->close();
        // If successful, return true.
        return true;
    }

}