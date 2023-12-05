<!-- MVC - Model File -->
<?php 

class Signup extends databaseHandler {

    // Check if users email exists in database.
    protected function checkUserEmail($email) {
        $conn = $this->connect();
        $sql = "SELECT * FROM users WHERE user_email = ?";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("s", $email);
        

        if (!$stmt->execute()) {
            $stmt->close();
            header("Location: ../signup.php?error=stmtfailed");
            die();
        }
        $result = $stmt->get_result(); // Get the result from the query.

        $resultCheck;

        if($result->num_rows > 0) { // If there is a result, then the email is already taken.
            $resultCheck = false; // Return false if the email is already taken.
        }
        else {
            $resultCheck = true; // Return true if the email is not taken.
        }
        $stmt->close();

        return $resultCheck;
    }

    protected function insertUser($first_name, $last_name, $email, $password) {
        $conn = $this->connect();
        $sql = "INSERT INTO users (user_first_name, user_last_name, user_email, user_password_hash) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Hash the password.
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $stmt->bind_param("ssss", $first_name, $last_name, $email, $hashed_password);

        if (!$stmt->execute()) {
            $stmt->close();
            header("Location: ../signup.php?error=stmtfailed");
            die();
        }

        // Return true if the user was created successfully.
        $resultCheck = $stmt->affected_rows > 0;
        return $resultCheck;
    }

}