<?php

	$content = file_get_contents("php://input");


	require_once('bot.php');
	require_once('keys.php');

	$message =  $_REQUEST['message'] ;
	$chatid =  $_REQUEST['chatid'] ;

	$bot = new bot($bot_token);
	$bot->send_direct($chatid, $message);

	$myfile = file_put_contents('resend_log.txt', $content.PHP_EOL , FILE_APPEND | LOCK_EX);
