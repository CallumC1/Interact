<?php 

class User extends UserModel {

    // public function __construct($first_name, $last_name, $email, $password) {
    //     $this->first_name = $first_name;
    //     $this->last_name = $last_name;
    //     $this->email = $email;
    //     $this->password = $password;
    // }

    public function signupUser($first_name, $last_name, $email, $password) {
        // var_dump($first_name, $last_name, $email, $password);
        if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
            header("Location: /interact/src/pages/signup.php?error=emptyField");
            exit();
        }

        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: /interact/src/pages/signup.php?error=invalidEmail");
            exit();
        }

        elseif ($this->checkUserEmailExists($email)) {
            header("Location: /interact/src/pages/signup.php?error=userExists");
            exit();
        }

        $this->insertUser($first_name, $last_name, $email, $password);
        header("Location: /interact/src/pages/login.php?msg=signupSuccess");
    }

    public function loginUser($email, $password) {
        // var_dump($first_name, $last_name, $email, $password);
        if (empty($email) || empty($password)) {
            echo("Empty Field");
            exit();
        }

        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo("Invalid Email");
            exit();
        }

        if ($row = $this->getUser($email, $password)) {
            // Assign session variables.
            session_start();
            session_regenerate_id();
            $_SESSION["user_data"] = [
                "user_id" => $row["user_id"],
                "user_first_name" => $row["user_first_name"],
                "user_last_name" => $row["user_last_name"],
                "user_email" => $row["user_email"],
            ];

            header("Location: /interact/src/pages/dashboard.php?msg=loginSuccess");
        }

    }

}