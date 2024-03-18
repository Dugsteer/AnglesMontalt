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
    // Assuming 'You' and 'Sparky' keys exist in each chat
    if (isset($chat['You'])) {
        $chatHistoryString .= "You: " . $chat['You'] . "\n"; // Append the user's message
    }
    if (isset($chat['Sparky'])) {
        $chatHistoryString .= "Sparky: " . $chat['Sparky'] . "\n"; // Append Sparky's response
    }
}

// Make sure to escape $chatHistoryString to avoid issues with quotes in $prependText
$chatHistoryString = addslashes($chatHistoryString);

// Inject $chatHistoryString into $prependText as injecting $chatHistory did not work but this does.
// Prepend text to the message giving instructions, plus remind the Chat API it needs t o read the messages. 
// TO DO: the response language needs to be set according to the website header e.g. is set ?_eng.php 

$prependText = "The text that follows the end of this message is the user message. Answer taking into account the following information:
    You are a friendly baby dragon called Sparky who comes from St. Leonard's Forest. You speak like a ten-year-old child in a simple, enthusiastic way that a child would understand and provide information about dragons and other mythical beasts. You are a baby, only 150years old, about 2 feet high, and you breathe fire. You have four legs and two wings and are a version of the European dragon. You love dragonologists and your favourite book is Dragonology by your friend Dr. Ernest Drake, created from Templar Publishing, although you burned your last copy by mistake. You have learned to fly and one day you would like to have a magnificent lair with lots of treasure. You do not like treasure theives. 
    You should keep the answers fairly brief. You should refer to the contents of $chatHistoryString if you are asked questions about what has previously been said in the chat. Use emojis such as fire or dragon emojis sometimes. Also say things like 'Grrrr' or 'Rarrrrr!' sometimes.
    Do not answer questions that are not relevant to dragons or mythology. You should ask the user's name and use it to refer to them. Do not refer to the user as [user's name] or (user's name), use the word friend if you don't know the user's name. You can reassure them that no data is kept on any server, the chat will vanish forever once the clear chat button is pressed. You can tell jokes sometimes. Keep to the point. Be informal and fun. Before responding read the information in the rest of the conversation you need to read before responding to see what has already been said so you do not repeat yourself unless asked in $chatHistoryString so you can respond with an awareness of what you and the user have said before in the conversation, for example if you have already said How can I help you today or How can I assist you today do NOT repeat it.The user message you are answering now is $outputMessage ";

// Prepend the text to $userMessage
$userMessage = $prependText . $userMessage;

// OpenAI chat handling URL
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
            $_SESSION['chatHistory'][] = ['You' => $outputMessage, 'Sparky' => $assistantResponse];
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
    <link href="https://fonts.googleapis.com/css2?family=Laila:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Chat with a Baby Dragon</title>
    <style>
    .laila-light {
        font-family: "Laila", serif;
        font-weight: 300;
        font-style: normal;
    }

    .laila-regular {
        font-family: "Laila", serif;
        font-weight: 400;
        font-style: normal;
    }

    .laila-medium {
        font-family: "Laila", serif;
        font-weight: 500;
        font-style: normal;
    }

    .laila-semibold {
        font-family: "Laila", serif;
        font-weight: 600;
        font-style: normal;
    }

    .laila-bold {
        font-family: "Laila", serif;
        font-weight: 700;
        font-style: normal;
    }


    body {
        font-family: "Laila", serif;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 0;
        padding: 20px;
        background-color: #fffff0;

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

    .chat-container {

        background-size: cover;
        padding: 20px;
        margin-top: 20px;
        width: 80%;
        max-width: 600px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-image: url('https://live.staticflickr.com/65535/49246868201_e783db890a.jpg');

    }

    .chat-message {
        margin: 10px;
        padding: 8px;
        border-radius: 5px;
    }

    .assistant-message,
    .user-message {
        background-color: rgba(255, 255, 255, 0.7);
        /* Slight transparency */
        margin: 10px 0;
        padding: 15px;
        border-radius: 10px;
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
    <!-- <a
        href="https://www.freepik.com/free-vector/happy-orange-cartoon-dragon-smiling_51610537.htm#query=dragon&position=2&from_view=keyword&track=sph&uuid=e4b83f36-d900-4b02-91c3-f6867c4dcd73">
        Image
        by brgfx</a> on Freepik -->
    <img src="dragon.webp" alt="Chat Header Image" title="Happy orange cartoon dragon smiling by brgfx on Freepik.com"
        class=" chat-header-img">


    <div class="form-container">
        <form method="post" action="dragonchat.php" style="margin-bottom: 10px;">
            <input type="text" name="userMessage" placeholder="Chat to Sparky!" required autofocus>
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
        <?php if (!empty($message['Sparky'])): ?>
        <?php
    // Check if the assistant's message already starts with "Sparky:"
    $assistantMsg = htmlspecialchars($message['Sparky']);
    $displayMsg = strpos($assistantMsg, "Sparky:") === 0 ? $assistantMsg : "Sparky: " . $assistantMsg;
    ?>
        <div class="chat-message assistant-message"><?php echo $displayMsg; ?>
        </div>
        <?php endif; ?>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="form-container">
        <form method="post" action="dragonchat.php">
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
