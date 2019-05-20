<?php

require_once('heyLucy.php');


class bot extends heyLucy
{
	var $bot_token;
	var $api_url = 'https://api.telegram.org/bot'.$this->bot_token.'/';
	var $commands = array('chatid', 'help', 'start', 'nuser', 'stat', 'test');
	var $commandsGroup = array('chatid', 'help', 'start', 'nuser', 'stat', 'test');
	var $replycommands = array();
	var $textreply = array();
	var $db = array (	"db_user"=>"",
						"db_pass"=>"",
						"db_host"=>"",
						"db_name"=>""  );
	var $usedb = FALSE;

	//$testBot->initDB($db);

	function __construct($bot_token) {
        $this->bot_token = $bot_token;
    }


	function start(){

		//$firstname = $update['message']['chat']['first_name'];

		$query="INSERT INTO utenti
				(chatid,username,firstname, lastname, language_code) VALUE
				('$this->chatId','$this->username','$this->firstname','$this->lastname','$this->language_code')";
		//$this->runQuery($query);

		//$this->help();

		$this->response .= "\n\n<b>Hi $this->username, welcome!</b>";
		//$this->sendLucy("Nuovo utente nel bot:\n $this->firstname@$this->username from $this->language_code", 1);

	}
	function nuser(){
		$query="SELECT * FROM users WHERE chatid = '".$this->chatId."' AND usergroup >0 ";
		$result = mysql_query($query, $this->conn_id);
		$num_rows = mysql_num_rows($result);
		if ($num_rows>0) {
			$query="SELECT * FROM users ";
			$result = mysql_query($query, $this->conn_id);
			$num_rows = mysql_num_rows($result);

			$this->response .= $num_rows. " user";


		}
		else {
			$this->response .= "unknow command!";

		}

	}
	function chatid(){
		$this->response .= "". $this->chatId." is your chatId";

	}
	function test(){
		$this->response .= "f";
		//$this->sendLucy("test", 2);
	}

	function send_direct($chatid, $message){

		$api_url = 'https://api.telegram.org/bot'.$this->bot_token.'/';

		$parameters =  array('chat_id' =>   $chatid , "text" => $message, "parse_mode" => "HTML");

		foreach ($parameters as $key => &$val) {
			// encoding to JSON array parameters, for example reply_markup
			if (!is_numeric($val) && !is_string($val)) {
			  $val = json_encode($val);
			}
		}
		$url = $api_url.'sendmessage?'.http_build_query($parameters);
		file_get_contents($url);
	}

	function stat(){
		$query="SELECT * FROM utenti WHERE chatid = '".$this->chatId."' AND usergroup >0 ";
		$result = mysql_query($query,$this->conn_id);
		$num_rows = mysql_num_rows($result);
		if ($num_rows>0) {

			$query="SELECT * FROM utenti ";
			$result = mysql_query($query, $this->conn_id);
			$num_rows = mysql_num_rows($result);
			$this->response .= $num_rows. " user\n";

			$query="SELECT * FROM alert ";
			$result = mysql_query($query, $this->conn_id);
			$num_rows = mysql_num_rows($result);
			$this->response .=  $num_rows. " alert totali\n";

			$query="SELECT * FROM alert WHERE enable=1";
			$result = mysql_query($query, $this->conn_id);
			$num_rows = mysql_num_rows($result);
			$this->response .= $num_rows. " alert abilitati\n";

			$query="SELECT * FROM alert GROUP BY chatid";
			$result = mysql_query($query, $this->conn_id);
			$num_rows = mysql_num_rows($result);
			$this->response .=  $num_rows. " utenti con alert\n";



		}
		else {
			$this->response .=  "unknow command!";

		}

	}

}
?>
