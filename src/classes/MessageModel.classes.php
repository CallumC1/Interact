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

    // Add a like
    // Could maybe be moved to its own likeModel class

    protected function insertLike($messageId, $user_id) {

        $sql = "INSERT INTO likes (message_id, user_id) VALUES (?, ?)";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ii", $messageId, $user_id);

        if (!$stmt->execute()) {
            $stmt->close();
            echo("Error in insertLike statement.");
            return false;
            die();
        }

        $stmt->close();
        return true;
    }

    protected function removeLike($messageId, $user_id) {

        $sql = "DELETE FROM likes WHERE message_id = ? AND user_id = ?";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ii", $messageId, $user_id);

        if (!$stmt->execute()) {
            $stmt->close();
            echo("Error in insertLike statement.");
            return false;
            die();
        }

        $stmt->close();
        return true;
    }

    // protected function userHasLiked($messageId, $userId) {
    //     $sql = "SELECT * FROM likes WHERE message_id = ? AND user_id = ?";
    //     $conn = $this->connect();
    //     $stmt = $conn->prepare($sql);
    
    //     $stmt->bind_param("ii", $messageId, $userId);
    //     $stmt->execute();
    
    //     $result = $stmt->get_result();
    
    //     $stmt->close();
    
    //     return $result->num_rows > 0; // true if user has liked, false if not
    // }

}