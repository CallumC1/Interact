<?php
session_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/databaseHandler.classes.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/MessageModel.classes.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/MessageHandler.classes.php");

$action = isset($_POST["action"]) ? $_POST["action"] : "";


if ($action == "getMsgs") {
    $messageHandler = new MessageHandler();

    if (isset($_POST["lastMessageId"])) {
        $lastMessageId = $_POST["lastMessageId"];
        $result = $messageHandler->getMessagesSince($lastMessageId);
        // If no new messages, return noNewMsgs and do not update.
        if ($result->num_rows == 0) {
            echo(json_encode(["result" => "noNewMsgs"]));
            die();
        }

    } else {
        $result = $messageHandler->getAllMessages();
        if ($result->num_rows == 0) {
            echo(json_encode(["result" => "noMsgs"]));
            die();
        }    
    }

    $allMsgs = [];
    while ($row = $result->fetch_assoc()) {
        $sender_data = UserModel::userByID($row["sender_id"]);
        $fullname = $sender_data["user_first_name"] . " " . $sender_data["user_last_name"];
        $msg = [
            "fullname" => $fullname,
            "message" => $row["message"],
            "message_id" => $row["message_id"],
            "liked" => UserModel::userHasLiked($row["message_id"], $_SESSION["user_data"]["user_id"]),
        ];
        array_push($allMsgs, $msg);
    }
    echo(json_encode(["result" => $allMsgs]));

} 
elseif ($action == "sendMsg") {
    $messageHandler = new MessageHandler();
    $sender_id = $_SESSION["user_data"]["user_id"];
    $message = $_POST["message"];
    
    if ($messageHandler->sendMessage($sender_id, $message)) {
        echo(json_encode(["result" => "success"]));
    } else {
        echo(json_encode(["result" => "failed"]));
    }
}    
// Like Messages
elseif ($action == "likeMsg") {
    $messageHandler = new MessageHandler();
    $user_id = $_SESSION["user_data"]["user_id"];
    $message_id = $_POST["msgId"];

    $like = $messageHandler->likeMessage($message_id, $user_id);
    if ($like == "alreadyLiked") {
        echo(json_encode(["result" => "alreadyLiked"]));#

    } elseif ($like == "success") {
        echo(json_encode(["result" => "success"]));
    } else {
        echo(json_encode(["result" => "failed"]));
    }


} else {
    echo("Error: No action specified.");
    die();
}
