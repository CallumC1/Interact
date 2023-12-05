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
            // header("Location: ../signup.php?error=emptyInput");
            echo("Empty input");
            die();
        }
        if ($this->invalidName() == false) {
            // header("Location: ../signup.php?error=invalidName");
            echo("Invalid name");
            die();
        }
        if ($this->invalidEmail() == false) {
            // header("Location: ../signup.php?error=invalidEmail");
            echo("Invalid email");
            die();
        }
        if ($this->emailTaken() == false) {
            // header("Location: ../signup.php?error=alreadyUser");
            echo("Email taken");
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
        $result;
        if(!$this->checkUserEmail($this->email)) {
            $result = false; // Return false if the email is already taken.
        }
        else {
            $result = true; // Return true if the email is not taken.
        }
        return $result;
    }

}