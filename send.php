<?php

	require_once('bot.php');

	$message =  $_REQUEST['message'] ;
	$chatid =  $_REQUEST['chatid'] ;

	bot::send_direct($chatid, $message);
