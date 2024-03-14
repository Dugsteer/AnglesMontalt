<?php
// Your OpenAI API key
 include "includes/apikey.php";

$assistantResponse = "";
$userMessage = "";

// Check if the REQUEST_METHOD is set and if the form was submitted
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userMessage']) && !empty($_POST['userMessage'])) {
    $userMessage = trim($_POST['userMessage']);

    // Your OpenAI Assistant's message handling URL
    $apiUrl = "https://api.openai.com/v1/chat/completions";

    // Prepare the data for the POST request
    $postData = [
        "model" => "gpt-3.5-turbo", // Adjust based on your assistant's model
        "messages" => [
            ["role" => "user", "content" => $userMessage]
        ]
    ];

    // Initialize cURL session
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $apiKey"
    ]);

    // Execute cURL request and capture the response
    $response = curl_exec($ch);
    // Close cURL session
    curl_close($ch);

    if ($response) {
        $responseData = json_decode($response, true);
        if (isset($responseData['choices'][0]['message']['content'])) {
            $assistantResponse = $responseData['choices'][0]['message']['content'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with Assistant</title>
    <style>
    .chat-message {
        margin: 10px;
        padding: 8px;
        border-radius: 5px;
    }

    .assistant-message {
        background-color: #eef;
    }

    .user-message {
        background-color: #ddf;
    }

    </style>
</head>

<body>

    <form method="post" action="chat.php">
        <input type="text" name="userMessage" placeholder="Type your message here..." required autofocus>
        <button type="submit">Send</button>
    </form>

    <!-- Display the conversation -->
    <div class="chat-container">
        <?php if (!empty($userMessage)): ?>
        <div class="chat-message user-message">You: <?php echo htmlspecialchars($userMessage); ?></div>
        <?php endif; ?>
        <?php if (!empty($assistantResponse)): ?>
        <div class="chat-message assistant-message">Assistant: <?php echo htmlspecialchars($assistantResponse); ?></div>
        <?php endif; ?>
    </div>

    <script>
    // Scroll to the bottom of the chat container to show the latest messages
    var chatContainer = document.querySelector(".chat-container");
    chatContainer.scrollTop = chatContainer.scrollHeight;
    </script>

</body>

</html>
