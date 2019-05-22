<?php

	$content = file_get_contents("php://input");
	$json    = json_decode($content, true);

	require_once('bot.php');
	require_once('keys.php');


	$chatid =  $_REQUEST['chatid'] ;

	$message = "✅<b>New push on ".$json['repository']['name']."</b>
<b>Author:</b> ".$json['push']['changes']['new']['target']['author']['user']['display_name']."
<b>Message:</b> ".$json['push']['changes']['new']['target']['message'];


	$bot = new bot($bot_token);
	$bot->send_direct($chatid, $message);

	$myfile = file_put_contents('git_alert_log.txt', $content.PHP_EOL , FILE_APPEND | LOCK_EX);
