// client-side chat.js for messaging system

// Function to load messages for the chat interface
function loadMessages() {
    const freelancerId = new URLSearchParams(window.location.search).get('freelancer_id');
    const clientId = new URLSearchParams(window.location.search).get('client_id');

    fetch(`index.php?controller=client&action=loadMessages&client_id=${clientId}&freelancer_id=${freelancerId}`)
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
        });
}

// Send the message using AJAX
// client-side chat.js for messaging system

// Function to send message
document.getElementById('message-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const message = document.getElementById('message').value;
    const freelancerId = new URLSearchParams(window.location.search).get('freelancer_id');
    const clientId = new URLSearchParams(window.location.search).get('client_id');

    // Send the message using AJAX
    fetch('index.php?controller=client&action=sendMessage', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `client_id=${clientId}&message=${encodeURIComponent(message)}&freelancer_id=${freelancerId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadMessages();  // Reload messages after sending
            document.getElementById('message').value = '';  // Clear the message input field
        } else {
            alert(data.error);  // Show error if message wasn't sent
        }
    });
});

// Load messages on page load
window.onload = loadMessages;



