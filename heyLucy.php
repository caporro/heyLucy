<?php
/*
	HeyLucy v1.0.0
	a simply telegram bot
*/
class heyLucy
{
	var $input;
	var $inputType; //message, callback_query, photo, ecc
	var $chatId;
	var $textReceived;
	var $firstname;
	var $command;
	var $typeMsg;
	var $response = '';
	var $api_url;
	var $lastname;
	var $username;
	var $language_code;
	var $reply_markup = "";
	var $message_id;
	var $updatemsg = FALSE;
	var $photo;
	var $conn_id;
	var $fromchat;
	var $at = FALSE;
	var $bot_token;



	function __construct(){
       	//Api key Telegram bot
		$this->api_url = 'https://api.telegram.org/bot'.$this->bot_token.'/';
		$this->api_url_file = 'https://api.telegram.org/file/bot'.$this->bot_token.'/';

    }
	function initDB($db){

		$db_user=$db['db_user'];
		$db_pass=$db['db_pass'];
		$db_host=$db['db_host'];
		$db_name=$db['db_name'];

		// db connection
		$this->conn_id = @mysql_connect($db_host, $db_user, $db_pass) or die ('500|Internal Server Error - DB connection error');
		@mysql_select_db($db_name, $this->conn_id) or die ('500|Internal Server Error - Select db error');
		@mysql_query("SET NAMES 'utf8'", $this->conn_id) or die ('500|Internal Server Error - error setting charset');

	}
	function input($input){
        $this->input = $input;
		//$this->sendLucy(json_encode($this->input));
		//$this->response .= json_encode($this->input);
		if (isset($input['message'])) {
			$this->inputType='message';
			$this->chatId = $input['message']['chat']['id'];
			$this->firstname = $input['message']['chat']['first_name'];
			$this->username = $input['message']['chat']['username'];
			$this->lastname = $input['message']['chat']['last_name'];
			$this->language_code = $input['message']['from']['language_code'];
			$this->fromchat = $input['message']['chat']['type'];


			if (isset($input['message']['document'])){
				$this->response .= json_encode($this->input);
			}
			if (isset($input['message']['photo'])){
				$this->response .= json_encode($this->input);

			}

				//$this->response .= json_encode($this->input);

			$this->textReceived = $input['message']['text'];
			$this->getCommand();

		}
		elseif(isset($input['callback_query'])) {
			$this->inputType='callback_query';
			$this->chatId = $input['callback_query']['message']['chat']['id'];
			$this->textReceived = $input['callback_query']['data'];
			$this->message_id =  $input['callback_query']['message']['message_id'];
		}


    }
	function run(){

		if ($this->inputType=='message'){

			$this->getTypeMsg();
			if ($this->typeMsg=="newcommand"){
				$this->delDialog();
				if ($this->fromchat == "group" || $this->fromchat == "supergroup") {
					if ($this->at) {
						if (in_array($this->command, $this->commandsGroup)) {

							$funcname = $this->command;
							$this->$funcname();
						}
						else {
							$this->response .= "This command is forbidden in a group";

						}
					}
				}
				else {
					if (in_array($this->command, $this->commands)) {

						$funcname = $this->command;
						$this->$funcname();
					}
					else {
						$this->response .= "Unknow Command!";

					}
				}
			}
			elseif($this->typeMsg=="symplytext"){
				if ($this->fromchat != "group" && $this->fromchat != "supergroup" ) {


						//verifica se ci sia un dialogo in corso o semplice testo
						$query="SELECT * FROM temp WHERE chatid = $this->chatId";

						$result = mysql_query($query, $this->conn_id);

						while ($data= mysql_fetch_assoc($result)) {
							$attesa_risposta = $data['attesa_risposta'];
							$comandi = $data['comandi'];
							$comandi = explode("|", $comandi);
						}
						if (in_array($attesa_risposta, $this->textreply)) {
							$funcname = $attesa_risposta;
							$this->$funcname($comandi);
						}
						else {
							$this->response .= "unknow!";

						}
				}

			}
		}
		elseif ($this->inputType=='callback_query'){
			$this->delDialog();
			$comandi = explode("|", $this->textReceived);
			if (in_array($comandi[0], $this->replycommands)) {
					$funcname = $comandi[0].$comandi[1];
					$this->$funcname($comandi);
				}
			else {
					$this->response .= "Error!";
				}
		}
    }
	function getTypeMsg(){

       	if ($this->inputType=="message"){
			if ($this->getCommand()){
				$this->typeMsg = "newcommand";
				//$this->sendmsg();
			}
			else {
				$this->typeMsg = "symplytext";
			}
		}

    }
	function getCommand(){

		if ($this->textReceived[0]=="/"){

			$comando = explode(' ', $this->textReceived);
			if (strpos($comando[0], "@")!==false) {
					$this->at = TRUE;
					$comando = explode('@', $comando[0]);
			}

			$this->command = substr($comando[0], 1);
		}
		else {
			$this->command = FALSE;
		}
		return $this->command;
	}
	function delDialog(){
		$query="DELETE FROM temp WHERE chatid = $this->chatId";
		//mysql_query($query, $this->conn_id);
	}
	function runQuery($query){

		$result = mysql_query($query, $this->conn_id);
		return $data= mysql_fetch_assoc($result);
	}
	function send(){
		if (!$this->updatemsg)
				$this->sendmsg();
		else
				$this->editmsg();

	}
	function sendmsg(){
		$parameters = array(
			'chat_id' => $this->chatId , //28021516,
			 "parse_mode" => "HTML");
		$parameters["text"] = $this->response;
		$parameters["reply_markup"] = $this->reply_markup;
		foreach ($parameters as $key => &$val) {
				// encoding to JSON array parameters, for example reply_markup
				if (!is_numeric($val) && !is_string($val)) {
				  $val = json_encode($val);
				}
			}

			$url = $this->api_url.'sendmessage?'.http_build_query($parameters);
			file_get_contents($url);
	}
	function editmsg(){

		$parameters = array(
			'chat_id' => $this->chatId , //28021516,
			 "parse_mode" => "HTML");
		$parameters["text"] = $this->response;
		$parameters["message_id"] =  $this->message_id;
		$parameters["reply_markup"] = $this->reply_markup;
		foreach ($parameters as $key => &$val) {
			// encoding to JSON array parameters, for example reply_markup
			if (!is_numeric($val) && !is_string($val)) {
			  $val = json_encode($val);
			}
		}

		$url = $this->api_url.'editMessageText?'.http_build_query($parameters);
		file_get_contents($url);
	}
	function sendphoto(){


			$parameters = array(
			'chat_id' => $this->chatId,
			 'parse_mode' => 'HTML');
			$parameters['photo'] = $this->photo;


			foreach ($parameters as $key => &$val) {
				// encoding to JSON array parameters, for example reply_markup
				if (!is_numeric($val) && !is_string($val)) {
				  $val = json_encode($val);
				}
			}

			$url = $this->api_url.'sendPhoto?'.http_build_query($parameters);
			file_get_contents($url);


	}
	function send_direct($chatid, $message){

		$api_url = 'https://api.telegram.org/bot'.$this->$bot_token.'/';

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
	function post_async($url, $params){
		foreach ($params as $key => &$val) {
		  if (is_array($val)) $val = implode(',', $val);
			$post_params[] = $key.'='.urlencode($val);
		}
		$post_string = implode('&', $post_params);

		$parts=parse_url($url);

		$fp = fsockopen($parts['host'],
			isset($parts['port'])?$parts['port']:80,
			$errno, $errstr, 30);

		$out = "POST ".$parts['path']." HTTP/1.1\r\n";
		$out.= "Host: ".$parts['host']."\r\n";
		$out.= "Content-Type: application/x-www-form-urlencoded\r\n";
		$out.= "Content-Length: ".strlen($post_string)."\r\n";
		$out.= "Connection: Close\r\n\r\n";
		if (isset($post_string)) $out.= $post_string;

		fwrite($fp, $out);
		while (!feof($fp)) $result .= fread($fp,32000);
		fclose($fp);
	}

}
?>
