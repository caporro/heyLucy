<?php

	$content = file_get_contents("php://input");
	$json    = json_decode($content, true);

	require_once('bot.php');
	require_once('keys.php');

	$chatid =  $_REQUEST['chatid'];
	$githost =  $_REQUEST['githost'];

	if ($githost=='github') {

		$message = "✅<b>New push on ".$json['repository']['name']."</b>
<b>Author:</b> ".$json['head_commit']['author']['name']."
<b>Message:</b> ".$json['head_commit']['message'];

	}
	elseif ($githost == 'bitbucket') {

		$message = "✅<b>New push on ".$json['repository']['name']."</b>
<b>Author:</b> ".$json['push']['changes'][0]['new']['target']['author']['user']['display_name']."
<b>Message:</b> ".$json['push']['changes'][0]['new']['target']['message'];

	}


	$bot = new bot($bot_token);
	$bot->send_direct($chatid, $message);

	file_put_contents('git_alert_log.txt', $content.PHP_EOL , FILE_APPEND | LOCK_EX);
?>
