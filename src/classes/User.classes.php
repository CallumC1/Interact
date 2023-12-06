<?php 
include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/UserModel.classes.php");


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
            echo("Empty Field");
            exit();
        }

        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo("Invalid Email");
            exit();
        }

        elseif ($this->checkUserEmailExists($email)) {
            echo("User with email already exists!");
            exit();
        }

        $this->insertUser($first_name, $last_name, $email, $password);
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

        $this->getUser($email, $password);
    }

}