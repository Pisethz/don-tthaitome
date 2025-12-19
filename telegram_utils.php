<?php
include 'telegram_config.php';

function sendTelegramMessage($message) {
    global $telegram_bot_token, $telegram_chat_id;
    
    if (empty($telegram_bot_token) || empty($telegram_chat_id)) {
        return;
    }

    $url = "https://api.telegram.org/bot" . $telegram_bot_token . "/sendMessage";
    $data = [
        'chat_id' => $telegram_chat_id,
        'text' => $message,
        'parse_mode' => 'HTML'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
}

function sendTelegramPhoto($photoPath, $caption = "") {
    global $telegram_bot_token, $telegram_chat_id;

    if (empty($telegram_bot_token) || empty($telegram_chat_id)) {
        return;
    }

    $url = "https://api.telegram.org/bot" . $telegram_bot_token . "/sendPhoto";
    
    if (function_exists('curl_file_create')) {
        $cFile = curl_file_create($photoPath);
    } else { 
        $cFile = '@' . realpath($photoPath);
    }

    $data = [
        'chat_id' => $telegram_chat_id,
        'photo' => $cFile,
        'caption' => $caption
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    
    // Debug log
    file_put_contents("debug_telegram.log", "Result: " . $result . "\n", FILE_APPEND);
}

?>
