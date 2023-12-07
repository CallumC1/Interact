<?php

class MessageModel extends databaseHandler {

    protected function insertMessage($sender_id, $message) {

        $sql = "INSERT INTO messages (sender_id, message ) VALUES (?, ?)";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("is", $sender_id, $message);

        if (!$stmt->execute()) {
            $stmt->close();
            echo("Error in insertMessage statement.");
            return false;
            die();
        }

        $stmt->close();
        return true;
    }

    protected function getAllMessagesDb() {
        $sql = "SELECT * FROM messages ORDER BY message_id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        if (!$stmt->execute()) {
            $stmt->close();
            echo("Error in getMessages statement.");
            return false;
            die();
        }

        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

    protected function getMessagesSinceDb($lastMessageId) {
        $sql = "SELECT * FROM messages WHERE message_id > ? ORDER BY message_id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("i", $lastMessageId);

        if (!$stmt->execute()) {
            $stmt->close();
            echo("Error in getMessages statement.");
            return false;
            die();
        }

        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

}