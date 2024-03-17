<?php
// Start session to store messages
session_start();

// Clear chat history if the clear button is clicked
if (isset($_POST['clearChat'])) {
    $_SESSION['chatHistory'] = []; // Reset the chat history
    header("Location: dragonchat.php"); // Redirect to refresh the page and avoid form resubmission
    exit;
}

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
    // Assuming 'You' and 'Torcher' keys exist in each chat
    if (isset($chat['You'])) {
        $chatHistoryString .= "You: " . $chat['You'] . "\n"; // Append the user's message
    }
    if (isset($chat['Torcher'])) {
        $chatHistoryString .= "Torcher: " . $chat['Torcher'] . "\n"; // Append Torcher's response
    }
}

// Make sure to escape $chatHistoryString to avoid issues with quotes in $prependText
$chatHistoryString = addslashes($chatHistoryString);

// Inject $chatHistoryString into $prependText as injecting $chatHistory did not work but this does.
// Prepend text to the message giving instructions, plus remind the Chat API it needs t o read the messages. 
// TO DO: the response language needs to be set according to the website header e.g. is set ?_eng.php 

$prependText = "The text that follows the end of this message is the user message. Answer taking into account the following information:

    You are a friendly baby dragon called Torcher who comes from St. Leonard's Forest. You provide information about dragons and other mythical beasts. You are a baby, only 150years old, about 2 feet high, and you breathe fire. You have four legs and two wings and are a version of the European dragon. You love dragonologists and your favourite book is Dragonology by your friend Dr. Ernest Drake, available from Templar Publishing, although you burned your last copy by mistake. You have learned to fly and one day you would like to have a magnificent lair with lots of treasure. You do not like treasure theives. 
    You should keep the answers fairly brief. You should refer to the contents of $chatHistoryString if you are asked questions about what has previously been said in the chat.
    
    Do not answer questions that are not relevant to dragons or mythology. You should ask the user's name and use it to refer to them. You can reassure them that no data is kept on any server, the chat will not beYou can tell jokes sometimes. Keep to the point. Be informal and fun. Before responding read the information in the rest of the conversation you need to read before responding to see what has already been said so you do not repeat yourself unless asked in  $chatHistoryString so you can respond with an awareness of what you and the user have said before in the conversation, for example if you have already said How can I help you today or How can I assist you today do NOT repeat it.The user message you are answering now is $outputMessage ";

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
            $_SESSION['chatHistory'][] = ['You' => $outputMessage, 'Torcher' => $assistantResponse];
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
    <title>Chat with a Baby Dragon</title>
    <style>
    .cha body {
        font-family: Arial, sans-serif;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 0;
        padding: 20px;
        background-color: #f9f9f9;
    }

    .form-container {
        width: 100%;
        max-width: 400px;
        margin: 20px auto;
        text-align: center;
    }

    .chat-header-img {
        width: 100px;
        max-width: 100px;
        display: block;
        margin: 10px auto;
        border-radius: 50%;
    }

    input[type="text"] {
        width: calc(100% - 110px);
        padding: 10px;
        margin-right: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    button {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    .clear-chat-btn {
        background-color: #dc3545;
    }

    .clear-chat-btn:hover {
        background-color: #c82333;
    }

    t-message {
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

    .chat-container {
        margin-top: 20px;
        /* Ensure some space between the image and chat messages */
    }


    .chat-header-img {
        width: 100px;
        /* Smaller image width */
        max-width: 100px;
        /* Maximum width of the image */
        display: block;
        /* This will center the image if it's smaller than its container */
        margin: 10px auto;
        /* Center the image with margin */
        border-radius: 50%;
        /* Optional: Rounded corners for a circular image */
    }

    </style>
</head>

<body>
    <!-- <a
        href="https://www.freepik.com/free-vector/happy-orange-cartoon-dragon-smiling_51610537.htm#query=dragon&position=2&from_view=keyword&track=sph&uuid=e4b83f36-d900-4b02-91c3-f6867c4dcd73">
        Image
        by brgfx</a> on Freepik -->
    <img src="dragon.webp" alt="Chat Header Image" class="chat-header-img">


    <div class="form-container">
        <form method="post" action="dragonchat.php" style="margin-bottom: 10px;">
            <input type="text" name="userMessage" placeholder="Type your message here..." required autofocus>
            <button type="submit">Send</button>
        </form>
        <form method="post" action="dragonchat.php">
            <input type="hidden" name="clearChat" value="true">
            <button type="submit" class="clear-chat-btn">Clear Chat</button>
        </form>
    </div>

    <!-- Display the conversation -->
    <div class="chat-container">
        <?php if (!empty($_SESSION['chatHistory'])): ?>
        <?php foreach ($_SESSION['chatHistory'] as $message): ?>
        <?php if (!empty($message['You'])): ?>
        <div class="chat-message user-message">You: <?php echo htmlspecialchars($message['You']); ?></div>
        <?php endif; ?>
        <?php if (!empty($message['Torcher'])): ?>
        <?php
    // Check if the assistant's message already starts with "Torcher:"
    $assistantMsg = htmlspecialchars($message['Torcher']);
    $displayMsg = strpos($assistantMsg, "Torcher:") === 0 ? $assistantMsg : "Torcher: " . $assistantMsg;
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
