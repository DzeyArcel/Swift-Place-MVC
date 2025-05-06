<?php include 'views/layouts/header.php'; ?>

<h2>Chat with Freelancer</h2>

<div id="chat-box" class="chat-box">
    <!-- Messages will be loaded here dynamically -->
</div>

<form id="message-form" method="post">
    <textarea id="message" name="message" placeholder="Type your message..." required></textarea>
    <button type="submit">Send</button>
</form>

<script>
// Function to load messages between the client and freelancer
function loadMessages() {
    const freelancerId = new URLSearchParams(window.location.search).get('freelancer_id');
    const clientId = <?= $_SESSION['client_id'] ?>; // Use the client ID from session

    fetch(`index.php?controller=client&action=loadMessages&client_id=${clientId}&freelancer_id=${freelancerId}`)
        .then(response => response.json())
        .then(data => {
            const chatBox = document.getElementById('chat-box');
            chatBox.innerHTML = "";
            data.forEach(msg => {
                const messageDiv = document.createElement('div');
                messageDiv.classList.add(msg.sender_type === 'client' ? 'sent' : 'received');
                messageDiv.innerHTML = `
                    <p><strong>${msg.sender_type === 'client' ? 'You' : 'Freelancer'}:</strong></p>
                    <p>${msg.message}</p>
                    <p class="timestamp">${new Date(msg.sent_at).toLocaleString()}</p>
                `;
                chatBox.appendChild(messageDiv);
            });
            chatBox.scrollTop = chatBox.scrollHeight; // Auto-scroll to the bottom
        });
}

// Send message via AJAX
document.getElementById('message-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const message = document.getElementById('message').value;
    const freelancerId = new URLSearchParams(window.location.search).get('freelancer_id');
    const clientId = <?= $_SESSION['client_id'] ?>;

    fetch('index.php?controller=client&action=sendMessage', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `client_id=${clientId}&message=${encodeURIComponent(message)}&freelancer_id=${freelancerId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadMessages(); // Reload messages after sending
            document.getElementById('message').value = ''; // Clear the message input field
        } else {
            alert(data.error); // Show error if message wasn't sent
        }
    });
});

// Load messages on page load
window.onload = loadMessages;
</script>

<style>
    .sent { background-color: #e1ffc7; padding: 10px; margin: 5px; border-radius: 10px; text-align: right; }
    .received { background-color: #f0f0f0; padding: 10px; margin: 5px; border-radius: 10px; text-align: left; }
    .timestamp { font-size: 0.8em; color: gray; }
</style>

<?php include 'views/layouts/footer.php'; ?>
