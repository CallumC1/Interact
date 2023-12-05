<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/signup.classes.php");

class LoginContr extends Login {

    private $email;
    private $password;

    public function __construct($email, $password) {
        $this->email = $email;
        $this->password = $password;
    }

    public function loginUser() {
        if ($this->emptyInput() == false) {
            // header("Location: ../signup.php?error=emptyInput");
            echo("Empty input");
            die();
        }

        $this->getUser($this->email, $this->password);
    }

    // Check for empty inputs.
    private function emptyInput() {
        $result;
        if(empty($this->email) || empty($this->password)) {
            $result = false;
        }
        else {
            $result = true;
        }
        return $result;
    }



}