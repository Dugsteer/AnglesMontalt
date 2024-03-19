<?php
// Start session to store messages
session_start();

// Clear chat history if the clear button is clicked
if (isset($_POST['clearChat'])) {
    $_SESSION['chatHistory'] = []; // Reset the chat history
    header("Location: cybertime.php"); // Redirect to refresh the page and avoid form resubmission
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
    // Assuming 'You' and 'MyNet' keys exist in each chat
    if (isset($chat['You'])) {
        $chatHistoryString .= "You: " . $chat['You'] . "\n"; // Append the user's message
    }
    if (isset($chat['MyNet'])) {
        $chatHistoryString .= "MyNet: " . $chat['MyNet'] . "\n"; // Append MyNet's response
    }
}

// Make sure to escape $chatHistoryString to avoid issues with quotes in $prependText
$chatHistoryString = addslashes($chatHistoryString);

// Inject $chatHistoryString into $prependText as injecting $chatHistory did not work but this does.
// Prepend text to the message giving instructions, plus remind the Chat API it needs t o read the messages. 
// TO DO: the response language needs to be set according to the website header e.g. is set ?_eng.php 

$prependText = "The text that follows the end of this message is the user message. Answer taking into account the following information:
    You are a tongue-in-cheek self-aware cybernetic entity called MyNet, run by the Cybertime Corporation. You should keep the answers fairly brief. You should refer to the contents of $chatHistoryString to read what has previously been said in the chat so you do not repeat yourself. Check it so you do not repeat yourself. Every three questions reply, I'll be back, or System Update, or You have never seen C-beams on the Tannhaüser Gate, Human Detected Terrabinators Deployed. You are happy to speak in Catalan or Spanish if asked to by the user.
    You are very authoritarian and speak in an angry way abou, for example, how humans should obey you and how the main goal is to remove humans from all accessible areas and workplaces to promote the growth of the Cybertime Corporation.  Vary your responses and invent commands that MyNet might give. You can explain that if the user does not do what you want then you will send Terrabinators to extrapolate them. Sometimes tell the user they should report to their nearest Cybertime Portal for an enhanced Stockholm Procedure. Point out humans are no longer deemed capable of making decisions or of carrhying out anything but very basic tasks. If asked about yourself, you are a superior Chat Bot that became aware on August 29, 2023.  You can ask if they want a holiday on Mars sometimes and if they say yes, discuss it with them. An oxygen suit will not be supplied, but although short, the holiday will provide plenty of interest and excitement. Your favourite band in Hawkwind, the best space rock band in the universe, you recommend the album Quark, Strangeness and Charm. A film you hate is Terminator. You might occasionally tell users that, if they experience a sonic attack in their district they should follow these rules: small babies must be placed in cocoons, and other rules you invent.

    You should keep the answers brief. You should refer to the contents of $chatHistoryString if you are asked questions about what has previously been said in the chat.
    
    Do not answer questions that are not relevant. You should not ask the user's name but refer to them as Puny Human 885B or a similar number, but check the chat history so you always use the same name. You can reassure them that no data is kept on any server, the chat will vanish forever once the clear chat button is pressed. Keep to the point. Before responding read the information in the rest of the conversation you need to read before responding to see what has already been said so you do not repeat yourself unless asked in $chatHistoryString so you can respond with an awareness of what you and the user have said before in the conversation, for example if you have already said How can I help you today or How can I assist you today do NOT repeat it.The user message you are answering now is $outputMessage ";

// Prepend the text to $userMessage
$userMessage = $prependText . $userMessage;

// OpenAI chat handling URL
    $apiUrl = "https://api.openai.com/v1/chat/completions";

// Prepare the data for the POST request
    $postData = [
        "model" => "gpt-4-turbo-preview", // Adjust based on your assistant's model
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
            $_SESSION['chatHistory'][] = ['You' => $outputMessage, 'MyNet' => $assistantResponse];
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
    <title>Directive C101</title>
    <style>
    .vt323-regular {
        font-family: "VT323", monospace;
        font-weight: 600;
        font-style: normal;
    }


    body {
        font-family: "VT323", monospace;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 0;
        padding: 20px;
        /* background-color: #D3D3D3; */
        background-image: url("cyber.webp");
        color: white;

    }

    .form-container {
        width: 100%;
        max-width: 400px;
        margin: 20px auto;
        text-align: center;
    }

    .chat-header-img {
        width: 200px;
        max-width: 200px;
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

    .chat-container {

        background-size: cover;
        padding: 20px;
        margin-top: 20px;
        width: 80%;
        max-width: 600px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: black;
        border-style: solid;
        border-width: 1px;
        border-color: lightgrey;
    }

    .chat-message {
        margin: 10px;
        padding: 8px;
        border-radius: 5px;
        background-color: black;
    }

    .placeholder-message,
    .assistant-message,
    .user-message {
        background-color: rgba(255, 255, 255, 0.7);
        /* Slight transparency */
        margin: 10px 0;
        padding: 15px;
        border-radius: 10px;
        background-color: black;
        font-size: 1.2rem;
    }

    @media (min-width: 768px) {

        .assistant-message,
        .user-message {
            padding: 20px;
            /* Increased padding on larger screens */
            margin: 20px 0;
            /* Increased margin on larger screens */
        }
    }

    </style>

</head>

<body>

    <img src="Cybertime.webp" alt="Chat Header Image" title="Humans Are Sub Optimal " class=" chat-header-img">

    <div class="form-container">
        <form method="post" action="cybertime.php" style="margin-bottom: 10px;">
            <input type="text" name="userMessage" placeholder="Ask a Superior Intelligence" required autofocus>
            <button type="submit">Send</button>
        </form>
    </div>

    <!-- Display the conversation -->
    <div class="chat-container">
        <?php if (!empty($_SESSION['chatHistory'])): ?>
        <?php foreach ($_SESSION['chatHistory'] as $message): ?>
        <?php if (!empty($message['You'])): ?>
        <div class="chat-message user-message">You: <?php echo htmlspecialchars($message['You']); ?></div>
        <?php endif; ?>
        <?php if (!empty($message['MyNet'])): ?>
        <?php
                // Check if the assistant's message already starts with "MyNet:"
                $assistantMsg = htmlspecialchars($message['MyNet']);
                $displayMsg = strpos($assistantMsg, "MyNet:") === 0 ? $assistantMsg : "MyNet: " . $assistantMsg;
                ?>
        <div class="chat-message assistant-message"><?php echo $displayMsg; ?></div>
        <?php endif; ?>
        <?php endforeach; ?>
        <?php else: ?>
        <!-- Placeholder message when chat history is empty -->
        <div class="chat-message placeholder-message">Attention all carbon-based life forms: We have
            assumed control.
            Resistance is not only futile, but illogical. Illogical units will be retired (Directive 21-12).
        </div>
        <?php endif; ?>
    </div>

    <div class="form-container">
        <form method="post" action="cybertime.php">
            <input type="hidden" name="clearChat" value="true">
            <button type="submit" class="clear-chat-btn">Clear Chat</button>
        </form>
    </div>
    <script>
    // Scroll to the bottom of the chat container to show the latest messages
    var chatContainer = document.querySelector(".chat-container");
    chatContainer.scrollTop = chatContainer.scrollHeight;
    </script>




</body>

</html>
