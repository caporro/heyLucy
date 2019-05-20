<?php

    // Do not touch
    require_once('bot.php');
    require_once('keys.php');
    $bot = new bot($bot_token);
    $API_URL = 'https://api.telegram.org/bot' . $bot->bot_token .'/';
    $method = 'setWebhook';
    $parameters = array('url' => $webhook_url);
    $url = $API_URL . $method. '?' . http_build_query($parameters);
    $handle = curl_init($url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($handle, CURLOPT_TIMEOUT, 60);
    $result = curl_exec($handle);
    print_r($result);

?>
