<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot AI</title>
    <style>
        #chatbox {
            width: 300px;
            height: 400px;
            border: 1px solid #ccc;
            overflow-y: scroll;
            padding: 10px;
        }
        .message { margin-bottom: 10px; }
        .user { color: blue; }
        .bot { color: green; }
    </style>
</head>
<body>
    <h3>Chatbot AI</h3>
    <div id="chatbox"></div>
    <input type="text" id="userInput" placeholder="Nhập tin nhắn..." />
    <button onclick="sendMessage()">Gửi</button>

    <script>
        function sendMessage() {
            let userInput = document.getElementById("userInput").value;
            let chatbox = document.getElementById("chatbox");

            if (userInput.trim() === '') return;

            // Hiển thị tin nhắn của người dùng
            chatbox.innerHTML += `<div class="message user"><b>Bạn:</b> ${userInput}</div>`;
            document.getElementById("userInput").value = '';

            // Gửi tin nhắn đến Laravel
            fetch('/chatbot', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message: userInput })
            })
            .then(response => response.json())
            .then(data => {
                let botMessage = data.choices[0].message.content;
                chatbox.innerHTML += `<div class="message bot"><b>Bot:</b> ${botMessage}</div>`;
                chatbox.scrollTop = chatbox.scrollHeight;
            })
            .catch(error => console.error('Lỗi:', error));
        }
    </script>
</body>
</html>
