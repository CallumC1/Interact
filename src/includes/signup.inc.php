<?php

if($_SERVER["REQUEST_METHOD"])
{

    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];


    include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/databaseHandler.classes.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/User.classes.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/UserModel.classes.php");
    $user = new User();
    
    $user->signupUser($first_name, $last_name, $email, $password);

}