<?php

if($_SERVER["REQUEST_METHOD"])
{

    $email = $_POST["email"];
    $password = $_POST["password"];


    // Include needed classes.

    include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/databaseHandler.classes.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/UserModel.classes.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/User.classes.php");
    $user = new User();
    
    $user->loginUser($email, $password);

}