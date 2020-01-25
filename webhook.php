<?php

      $file = 'debug.txt';

    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
    //file_put_contents($file, 'get:'.json_encode($_GET), FILE_APPEND );
    //file_put_contents($file, 'post:'.json_encode($_POST), FILE_APPEND );
    //file_put_contents($file, $_SERVER['HTTP_USER_AGENT'], FILE_APPEND );
    $content = file_get_contents("php://input");
    //file_put_contents($file, 'input: '.$content."\n", FILE_APPEND );

    require_once('bot.php');
    require_once('keys.php');
    //catch input data

    $update = json_decode($content, true);


	if(!$update){
		exit;
	}
      file_put_contents($file, 'content: '.$content."\n\n\n", FILE_APPEND );
	$bot = new bot($bot_token);

	$bot->input($update);

	$bot->run();
	// $bot->send();
	$bot->sendmsg();

    //

	 //$debug = ob_get_clean()."\n";
	file_put_contents($file, 'te '.$content."\n\n\n", FILE_APPEND );
?>
