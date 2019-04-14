<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once('bot.php');
	//catch input data
	$content = file_get_contents("php://input");
    $update = json_decode($content, true);

	if(!$update){
		exit;
	}

	$bot = new bot();

	$bot->input($update);
	$bot->run();
	$bot->send();
    //
	// $file = 'debug.txt';
	// //$debug = ob_get_clean()."\n";
	// file_put_contents($file, $content, FILE_APPEND );
?>
