<?php
session_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/databaseHandler.classes.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/MessageModel.classes.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/MessageHandler.classes.php");

$post_data = json_decode(file_get_contents('php://input'), true);
$action = isset($post_data["action"]) ? $post_data["action"] : "";


header('Content-Type: application/json');
switch ($action) {
    case "fetchMsgs":
        // Long poll for new messages only.
        set_time_limit(0); // Prevents script from timing out.
        ob_implicit_flush(true); // Prevents script from buffering output.
        
        // Initialize message handler 
        $messageHandler = new MessageHandler();
    

        if (!$post_data["lastMessageId"] == null) {
            // Long poll for new messages only.
            while (true) {
                $result = $messageHandler->getMessagesSince($post_data["lastMessageId"]);

                   // Release the session lock
                    session_write_close();

                if ($result->num_rows > 0) {
                    break;
                }
                sleep(1);
            }
        } 
        else {

            // Get all messages from database
            // If no messages, return noMsgs.
            $result = $messageHandler->getAllMessages();
            if ($result->num_rows == 0) {
                echo(json_encode(["result" => "noMsgs", "messages" => []]));
                exit();
            }    
        
        }
    
        // Initialize array to store all messages.
        $allMsgs = [];
        while ($row = $result->fetch_assoc()) {
            $sender_data = UserModel::userByID($row["sender_id"]);
            $fullname = $sender_data["user_first_name"] . " " . $sender_data["user_last_name"];
            $msg = [
                "fullname" => htmlspecialchars($fullname),
                "message" => htmlspecialchars($row["message"], ENT_QUOTES, 'UTF-8'),
                "message_id" => $row["message_id"],
                // Check if user has liked this message.
                "liked" => UserModel::userHasLiked($row["message_id"], $_SESSION["user_data"]["user_id"]),
            ];
            array_push($allMsgs, $msg);
        }
        echo(json_encode(["result" => "success", "messages" => $allMsgs]));
        exit();

        // End of fetchMsgs case.
        break;


    case "sendMsg":

        $messageHandler = new MessageHandler();
        $sender_id = $_SESSION["user_data"]["user_id"];
        $message = $post_data["message"];
        
        if ($messageHandler->sendMessage($sender_id, $message)) {
            echo(json_encode(["result" => "messageSendSuccess"]));
            exit();
        } else {
            echo(json_encode(["result" => "messageSendFailed"]));
            exit();
        }

        // End of sendMsg case.
        break;


    // End of switch statement.
    default:
        echo(json_encode(["result" => "ERROR"]));
        die();
        break;
}
