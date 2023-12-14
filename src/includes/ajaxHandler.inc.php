<?php
session_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/databaseHandler.classes.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/MessageModel.classes.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/MessageHandler.classes.php");

$post_data = json_decode(file_get_contents('php://input'), true);
$action = isset($post_data["action"]) ? $post_data["action"] : "";
// $action = isset($_POST["action"]) ? $_POST["action"] : "";


header('Content-Type: application/json');
if ($action == "getMsgs") {
    set_time_limit(0); // Prevents script from timing out.
    ob_implicit_flush(true); // Prevents script from buffering output.
    $messageHandler = new MessageHandler();

    if (isset($post_data["lastMessageId"])) {
        // echo("lastMessageId is set");
        $lastMessageId = $post_data["lastMessageId"];
        while (true) {
            $result = $messageHandler->getMessagesSince($lastMessageId);
            if ($result->num_rows > 0) {
                echo($result->num_rows);
                break;
            }
            sleep(1);
        }

        // $result = $messageHandler->getMessagesSince($lastMessageId);
        // If no new messages, return noNewMsgs and do not update.
        if ($result->num_rows == 0) {
            echo(json_encode(["result" => "noNewMsgs", "messages" => []]));
            die();
        }

    } else {
        // No need to long poll for all msgs.
        $result = $messageHandler->getAllMessages();
        if ($result->num_rows == 0) {
            echo(json_encode(["result" => "noMsgs", "messages" => []]));
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
    echo(json_encode(["result" => "success", "messages" => $allMsgs]));
    die();
}


elseif ($action == "sendMsg") {
    $messageHandler = new MessageHandler();
    $sender_id = $_SESSION["user_data"]["user_id"];
    $message = $post_data["message"];
    
    if ($messageHandler->sendMessage($sender_id, $message)) {
        echo(json_encode(["result" => "success"]));
        exit();
    } else {
        echo(json_encode(["result" => "failed"]));
        exit();
    }
}    
// Like Messages
elseif ($action == "likeMsg") {
    $messageHandler = new MessageHandler();
    $user_id = $_SESSION["user_data"]["user_id"];
    $message_id = $post_data["msgId"];

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
