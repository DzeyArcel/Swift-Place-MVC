<?php

class Message
{
    // Fetch conversation between a client and a freelancer
    public static function getConversation($client_id, $freelancer_id)
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("
            SELECT m.*, u.first_name, u.last_name, u.profile_picture 
            FROM messages m
            JOIN users u ON m.sender_id = u.id
            WHERE (m.sender_id = ? AND m.receiver_id = ?) 
               OR (m.sender_id = ? AND m.receiver_id = ?)
            ORDER BY m.sent_at ASC
        ");
        $stmt->bind_param("iiii", $client_id, $freelancer_id, $freelancer_id, $client_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $messages = [];

        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }

        return $messages;
    }

    // Send a message from one user to another
    public static function sendMessage($sender_id, $receiver_id, $message)
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("INSERT INTO messages (sender_id, receiver_id, message, sent_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iis", $sender_id, $receiver_id, $message);

        return $stmt->execute();
    }

    // (Optional) Mark all messages from freelancer as read when viewed by client
    public static function markMessagesAsRead($sender_id, $receiver_id)
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("
            UPDATE messages 
            SET is_read = 1 
            WHERE sender_id = ? AND receiver_id = ? AND is_read = 0
        ");
        $stmt->bind_param("ii", $sender_id, $receiver_id);
        $stmt->execute();
    }
}
