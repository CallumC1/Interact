<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/signup.classes.php");

class SignupContr extends Signup {

    private $first_name;
    private $last_name;
    private $email;
    private $password;

    public function __construct($first_name, $last_name, $email, $password) {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->password = $password;
    }

    public function signupUser() {
        if ($this->emptyInput() == false) {
            header("Location: /interact/src/pages/signup.php?error=emptyInput");
            die();
        }
        if ($this->invalidName() == false) {
            header("Location: /interact/src/pages/signup.php?error=invalidName");
            die();
        }
        if ($this->invalidEmail() == false) {
            header("Location: /interact/src/pages/signup.php?error=invalidEmail");
            die();
        }
        if ($this->emailTaken() == true) {
            header("Location: /interact/src/pages/signup.php?error=takenUser");
            die();
        }

        $this->insertUser($this->first_name, $this->last_name, $this->email, $this->password);
    }

    // Check for empty inputs.
    private function emptyInput() {
        $result;
        if(empty($this->first_name) || empty($this->last_name) || empty($this->email) || empty($this->password)) {
            $result = false;
        }
        else {
            $result = true;
        }
        return $result;
    }

    // Check for invalid first / last names.
    private function invalidName() {
        $result;
        if(!preg_match("/^[a-zA-Z]*$/", $this->first_name) || !preg_match("/^[a-zA-Z]*$/", $this->last_name)) {
            $result = false;
        }
        else {
            $result = true;
        }
        return $result;
    }
    
    private function invalidEmail() {
        $result;
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $result = false;
        }
        else {
            $result = true;
        }
        return $result;
    }

    private function emailTaken() {
        $result = $this->checkUserEmail($this->email); // Return true if the email is taken.
        return $result;
    }

}