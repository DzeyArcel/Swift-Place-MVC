<!-- views/client/chat_with_freelancer.php -->

<main class="container">
    <h2 class="section-title">Chat with Freelancer</h2>

    <div id="chat-box" class="chat-box">
        <!-- Loop through the messages and display them -->
        <?php if (!empty($messages)): ?>
            <?php foreach ($messages as $msg): ?>
                <div class="message <?= $msg['sender_id'] == $client_id ? 'sent' : 'received' ?>">
                    <p><strong><?= htmlspecialchars($msg['sender_id'] == $client_id ? 'You' : $msg['first_name'] . ' ' . $msg['last_name']) ?>:</strong></p>
                    <p><?= nl2br(htmlspecialchars($msg['message'])) ?></p>
                    <p class="timestamp"><?= date("F j, Y, g:i a", strtotime($msg['sent_at'])) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No messages yet. Start the conversation!</p>
        <?php endif; ?>
    </div>

    <form id="message-form" method="post">
        <textarea id="message" name="message" placeholder="Type your message..." required></textarea>
        <button type="submit" id="send-btn">Send</button>
    </form>
</main>

<script src="public/js/chat.js"></script>
