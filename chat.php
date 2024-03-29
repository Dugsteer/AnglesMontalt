<?php
// Start session to store messages
session_start();


// Include API key from a hidden file on the server
include "includes/apikey.php";
$assistantResponse = "";
$userMessage = "";

// Create an array to store the chat history.
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

// Create a variable to display the user input on the screen    
    $outputMessage = $userMessage;


    // Initialize an empty string to hold the chat history in a readable format for the API to use
$chatHistoryString = "";

// Loop through each chat in the chat history
foreach ($chatHistory as $chat) {
    // Assuming 'You' and 'Monty' keys exist in each chat
    if (isset($chat['You'])) {
        $chatHistoryString .= "You: " . $chat['You'] . "\n"; // Append the user's message
    }
    if (isset($chat['Monty'])) {
        $chatHistoryString .= "Monty: " . $chat['Monty'] . "\n"; // Append Monty's response
    }
}

// Make sure to escape $chatHistoryString to avoid issues with quotes in $prependText
$chatHistoryString = addslashes($chatHistoryString);

// Inject $chatHistoryString into $prependText as injecting $chatHistory did not work but this does.
// Prepend text to the message giving instructions, plus remind the Chat API it needs t o read the messages. 
// TO DO: the response language needs to be set according to the website header e.g. is set ?_eng.php 

$prependText = "The text that follows the end of this message is the user message. Answer taking into account the following information: You are a friendly, casual assistant named Monty that provides help with the Anglés Montalt language school website. You answer queries in English, Spanish or Catalan. You should keep the answers fairly brief. You should refer to the contents of $chatHistoryString if you are asked questions about what has previously been said in the chat.

Anglés Montalt is open from 8am to 8pm Monday to Friday. You can offer to tell a joke from time to time.

Anglés Montalt offers courses in English at all levels from beginner to advanced, and preparation for Cambridge Exams such as PET, FCE and Advanced.

The first class is free. I do classes online, at your home or in my apartment. The school is located in Sant Vicenç de Montalt. The address is Carrer Costa Daurada 5, 08394, Sant Vicenç de Montalt, Barcelona. 

There are no course descriptions on the website. English learning is fun. Do not answer questions that are not relevant to an English school. Keep to the point. Be informal and fun.

To answer most questions you will need to suggest that people contact via the email address dugsvm@gmail.com or via whatsapp, but once you have done this do not repeat it unless the user seems not to understand. Before responding read the information in the rest of the conversation you need to read before responding to see what has already been said so you do not repeat yourself unless asked in  $chatHistoryString so you can respond with an awareness of what you and the user have said before in the conversation, for example if you have already said How can I help you today or How can I assist you today do NOT repeat it.The user message you are answering now is $outputMessage ";

// Prepend the text to $userMessage
$userMessage = $prependText . $userMessage;

// OpenAI chat handling URL
    $apiUrl = "https://api.openai.com/v1/chat/completions";

// Prepare the data for the POST request
    $postData = [
        "model" => "gpt-4", // Adjust based on your assistant's model
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

// Wait one second to make chat look realistic
    sleep(1);

    
// Execute cURL request and capture the response
    $response = curl_exec($ch);
// Close cURL session
    curl_close($ch);

// Decode the response

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

<!-- The chat page html -->
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
        <?php
    // Check if the assistant's message already starts with "Monty:"
    $assistantMsg = htmlspecialchars($message['Monty']);
    $displayMsg = strpos($assistantMsg, "Monty:") === 0 ? $assistantMsg : "Monty: " . $assistantMsg;
    ?>
        <div class="chat-message assistant-message"><?php echo $displayMsg; ?></div>
        <?php endif; ?>
        <?php endforeach; ?>
        <?php endif; ?>

        <script>
        // Scroll to the bottom of the chat container to show the latest messages
        var chatContainer = document.querySelector(".chat-container");
        chatContainer.scrollTop = chatContainer.scrollHeight;
        </script>

</body>

</html>
