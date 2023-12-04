<?php
    echo("test0");

if($_SERVER["REQUEST_METHOD"])
{
    echo("test1");

    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];


    // Instantiate SignupContr class

    include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/databaseHandler.classes.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/signup.classes.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/signup-contr.classes.php");
    $signup = new SignupContr($first_name, $last_name, $email, $password);
    
    $signup->signupUser();

}