// Function to load messages for the chat interface
function loadMessages() {
    const freelancerId = new URLSearchParams(window.location.search).get('freelancer_id');

    fetch(`index.php?controller=client&action=loadMessages&freelancer_id=${freelancerId}`)
        .then(response => response.json())
        .then(data => {
            const chatBox = document.getElementById('chat-box');
            chatBox.innerHTML = "";  // Clear previous messages

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

            chatBox.scrollTop = chatBox.scrollHeight;  // Auto-scroll to the bottom
        })
        .catch(error => console.error("Error loading messages:", error));
}

// Event listener for sending a message
document.getElementById('message-form').addEventListener('submit', function (event) {
    event.preventDefault();

    const message = document.getElementById('message').value.trim();
    const freelancerId = new URLSearchParams(window.location.search).get('freelancer_id');

    if (!message) {
        alert("Please enter a message.");
        return;
    }

    fetch('index.php?controller=client&action=sendMessage', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `message=${encodeURIComponent(message)}&freelancer_id=${freelancerId}`
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('message').value = '';
                loadMessages();  // Reload after sending
            } else {
                alert(data.error || "Failed to send message.");
            }
        })
        .catch(error => console.error("Send error:", error));
});

// Load messages when page loads
window.onload = () => {
    loadMessages();

    // Optional: refresh every 10 seconds
    setInterval(loadMessages, 10000);
};
