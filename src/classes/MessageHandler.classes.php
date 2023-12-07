<?php 
include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/UserModel.classes.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/interact/src/classes/User.classes.php");

class MessageHandler extends MessageModel {

    public function sendMessage($sender_id, $message) {
        // Send message to database
        // Return true if successful, false if not
        if (!$this->hasContent($message)) {
            header("Location: /interact/src/pages/dashboard.php?msg=emptyMessage");
            exit();
        }

        if ($this->insertMessage($sender_id, $message)) {
            header("Location: /interact/src/pages/dashboard.php?msg=success");
        } else {
            header("Location: /interact/src/pages/dashboard.php?msg=failed");
        }
    }

    public function getAllMessages() {
        // Get messages from database
        $result = $this->getAllMessagesDb();
        return $result;
    }

    public function getMessagesSince($lastMessageId) {
        // Get new messages from database
        $result = $this->getMessagesSinceDb($lastMessageId);
        return $result;
    }

    public function displayMessages() {
        // Display messages on page by fetching from model.

        $result = $this->getMessagesDb();
        while ($row = $result->fetch_assoc()) {
            $sender_data = UserModel::userByID($row["sender_id"]);
            $fullname = $sender_data["user_first_name"] . " " . $sender_data["user_last_name"];
            include($_SERVER["DOCUMENT_ROOT"] . "/interact/src/components/message.php");
        }

    }

    private function hasContent($message) {
        // Check if message is empty
        // Return true if empty, false if not
        if (preg_match('/^\s*$/', $message)) {
            return false;
        } else {
            return true;
        }
    }
}