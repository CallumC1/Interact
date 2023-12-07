<?php

if($_SERVER["REQUEST_METHOD"])
{
    session_start();
    $messageText = $_POST["textInput"];
    $sender_id = $_SESSION["user_data"]["user_id"];


    // Include needed classes.

    include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/databaseHandler.classes.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/MessageModel.classes.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/MessageHandler.classes.php");
    $messageHandler = new MessageHandler();
    
    $messageHandler->sendMessage($sender_id, $messageText);

    

}