<?php 

//include API key
include "includes/apikey.php";   

    // Initialize cURL
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/audio/speech');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $apiKey,
    'Content-Type: application/json'
));
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
    'model' => 'tts-1',
    'input' => 'Today is a wonderful day to build something people will not enjoy!',
    'voice' => 'alloy'
)));

$result = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    // Saving the result as an MP3 file
    file_put_contents('/Users/dug/Projects/AnglesMontalt/speech.mp3', $result);
}

curl_close($ch);
?>
