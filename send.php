<?php

	require_once('bot.php');
	require_once('keys.php');


	$bot = new bot($bot_token);

	$bot->send_direct(28021516, 'ciao');
