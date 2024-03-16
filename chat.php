<?php
// Your OpenAI API key
session_start();

  


include "includes/apikey.php";
$assistantResponse = "";
$userMessage = "";

if (!isset($_SESSION['chatHistory'])) {
    $_SESSION['chatHistory'] = [];
}

if (isset($_SESSION['chatHistory'])) {
    $chatHistory = $_SESSION['chatHistory'];
} else {
    // Initialize $chatHistory as an empty array if it doesn't exist in session
    $chatHistory = [];
}

// Check if the REQUEST_METHOD is set and if the form was submitted
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userMessage']) && !empty($_POST['userMessage'])) {
    $userMessage = trim($_POST['userMessage']);

    $outputMessage = $userMessage;

    // The text string you want to prepend to $userMessage
$prependText = "The text that follows the end of this message is the user message. Answer taking into account the following information: You are a friendly, casual assistant named Monty that provides help with the Anglés Montalt language school website. You answer queries in English, Spanish or Catalan. You should keep the answers fairly brief.

Anglés Montalt is open from 8am to 8pm Monday to Friday. You can offer to tell a joke from time to time.

Anglés Montalt offers courses in English at all levels from beginner to advanced, and preparation for Cambridge Exams such as PET, FCE and Advanced.

The first class is free. I do classes online, at your home or in my apartment. The school is located in Sant Vicenç de Montalt. The address is Carrer Costa Daurada 5, 08394, Sant Vicenç de Montalt, Barcelona. 

There are no course descriptions on the website. English learning is fun. Do not answer questions that are not relevant to an English school. Keep to the point. Be informal and fun.

To answer most questions you will need to suggest that people contact via the email address dugsvm@gmail.com or via whatsapp, but once you have done this do not repeat it unless the user seems not to understand. Before responding read the information in he rest of the conversation you need to read before responding to see what has already been said so you do not repeat yourself unless asked in  $chatHistory so you can respond with an awareness of what you and the user have said before in the conversation, for example if you have already said How can I help you today or How can I assist you today do NOT repeat it.The user message you are answering now is $outputMessage ";

// Prepend the text to $userMessage
$userMessage = $prependText . $userMessage;



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

    sleep(1);
    // Execute cURL request and capture the response
    $response = curl_exec($ch);
    // Close cURL session
    curl_close($ch);



 if ($response) {
        $responseData = json_decode($response, true);
        if (isset($responseData['choices'][0]['message']['content'])) {
            $assistantResponse = $responseData['choices'][0]['message']['content'];
            // Append the new messages to the session's chat history
            $_SESSION['chatHistory'][] = ['You' => $outputMessage, 'Monty' => $assistantResponse];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with Monty</title>
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
        <?php if (!empty($_SESSION['chatHistory'])): ?>
        <?php foreach ($_SESSION['chatHistory'] as $message): ?>
        <?php if (!empty($message['You'])): ?>
        <div class="chat-message user-message">You: <?php echo htmlspecialchars($message['You']); ?></div>
        <?php endif; ?>
        <?php if (!empty($message['Monty'])): ?>
        <div class="chat-message assistant-message">Monty: <?php echo htmlspecialchars($message['Monty']); ?></div>
        <?php endif; ?>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <script>
    // Scroll to the bottom of the chat container to show the latest messages
    var chatContainer = document.querySelector(".chat-container");
    chatContainer.scrollTop = chatContainer.scrollHeight;
    </script>

</body>

</html>
