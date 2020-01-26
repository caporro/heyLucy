<?php

      $logfile = 'logfile.txt';
      $content = file_get_contents("php://input");

      require_once('bot.php');
      require_once('keys.php');

      //catch input data
      $update = json_decode($content, true);

	if(!$update){
		exit;
	}

      $bot = new bot($bot_token);
	$bot->input($update);
	$bot->run();
	$bot->send();

	file_put_contents($logfile, 'content: '.$content."\n\n", FILE_APPEND );
?>
