<!-- MVC - Model File -->
<?php 

class Login extends databaseHandler {

    protected function getUser($email, $password) {
        $conn = $this->connect();
        $sql = "SELECT user_password_hash FROM users WHERE user_email = ?";
        $stmt = $conn->prepare($sql);

        // Hash the password.
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $stmt->bind_param("s", $email);

        if (!$stmt->execute()) {
            $stmt->close();
            header("Location: ../login.php?error=stmtfailed");
            die();
        }

        if ($stmt->affected_rows == 0) {
            $stmt->close();
            header("Location: ../login.php?error=usernotfound");
            die();
        }
        
        $password_hashed = $stmt->get_result()->fetch_assoc()["user_password_hash"];
        $check_password = password_verify($password, $password_hashed);

        $stmt->close();


        if ($check_password == false) {
            header("Location: ../login.php?error=incorrectpassword");
            die();
        } elseif ($check_password == true) {
            
            // Get all user data
            $sql = "SELECT * FROM users WHERE user_email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $row = $stmt->get_result()->fetch_assoc();

            // Execute & check if stmt failed.
            if (!$stmt->execute()) {
                $stmt->close();
                header("Location: ../login.php?error=stmtfailed");
                die();
            }


            session_start();
            $_SESSION["user_data"] = [
                "user_id" => $row["user_id"],
                "user_first_name" => $row["user_first_name"],
                "user_last_name" => $row["user_last_name"],
                "user_email" => $row["user_email"],
            ];

            $stmt->close();


        }


    }



}