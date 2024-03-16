<?php
session_start();

// Check if the chatHistory session variable exists and clear it
if (isset($_SESSION['chatHistory'])) {
    unset($_SESSION['chatHistory']);
    echo "Chat history cleared successfully.";
} else {
    echo "No chat history to clear.";
}
?>
