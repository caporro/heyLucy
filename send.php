<?php

	require_once('bot.php');
	require_once('keys.php');
	$message =  $_REQUEST['message'] ;
	$chatid =  $_REQUEST['chatid'] ;

	$bot = new bot($bot_token);

	$bot->send_direct($chatid, $message);
