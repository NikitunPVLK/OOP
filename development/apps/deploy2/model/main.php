<?php
/**
 * User Controller
 *
 * @author Taisiia Shakun
 * @global object $CORE->model
 * @package Model\Main
 */

namespace Model;

class Main {

	use \Library\Shared;

	public function coreuniwebhook(array $data):?array {
		$db = new classes\DBRepository();
		$post = new classes\Post();
		$service = new classes\TelegramService();
		$title = $data['title'];
		$text = $data['text'];
        $attachment = $data['attachment'];
		$chatid = $data['chatid'];	
		$chatid = explode('-', $chatid);
		foreach ($chatid  as $id) {
			if(!empty($id)) {	
				$post -> setTitle($title);
				$post -> setText($text);
				$post -> setAttachment($attachment);
				$post -> setId('-'.$id);
				$db -> add($post);
				$post = $db -> get('13684705-c3d5-11eb-a4ee-0242ac120004');
				
				$service -> Send($post);	

			}
		}
		return [$chatid];
	}
	
	public function telegramsetwebhook(array $data):?array {
		$key = ''; // Ключ API телеграм
		$url = 'https://feed.pnit.od.ua/telegram/receivedmessage';
        $answer = file_get_contents("https://api.telegram.org/bot$key/setWebhook?url=$url");
		return [true];
	}
	
	public function telegramreceivedmessage(array $data):?array {
		$update = json_decode(file_get_contents("php://input"), TRUE);
		$chatId = $update["message"]["chat"]["id"];
		$site;
		$text = $update["message"]["text"];
		$key = '';

		if (strpos($text, "/id") === 0) {
			$message = "Вот твой chat-id =" . $update["message"]["chat"]["id"];
			$answer = file_get_contents("https://api.telegram.org/bot$key/sendMessage?parse_mode=markdown&chat_id=$chatId&text=$message");
		}

		elseif (strpos($text, "/start") === 0) {
			$message = "Привет, я - Бот для кросспостинга" . 
			"\n\nЕсли хочешь воспользоваться моим функционалом - добавь меня в группу или канал" .
			"\n\nЧтобы я что-то запостил - тебе нужен chat-id".
			"\nТы всегда можешь его узнать при помощи команды /id" .
			"\n\nДля получения id канала, используй команду /chanelid\_chanelname (Например, /chanelid\_mychanel)".
			"\n\nДля создания поста, перейди на сайт https://feed.pnit.od.ua, расставь нужные id и заполни пост!";
			$message =urlencode($message);
			$answer = file_get_contents("https://api.telegram.org/bot$key/sendMessage?parse_mode=markdown&chat_id=$chatId&text=$message");
		}

		elseif (strpos($text, "/site") === 0) {
			$message = "Сайт для создания постов: https://feed.pnit.od.ua" . $site;
			$message =urlencode($message);
			$answer = file_get_contents("https://api.telegram.org/bot$key/sendMessage?parse_mode=markdown&chat_id=$chatId&text=$message");
		}

		elseif(strpos($text, "/chanelid_") === 0) {
			$chanelId = "@".substr($text, 10);
			$response = json_decode(file_get_contents("https://api.telegram.org/bot$key/sendMessage?chat_id=$chanelId&disable_notification=true&text=test"), true);
			
			if(isset($response['result']['chat']['id'])){ 
				$messageId = $response['result']['message_id'];
				file_get_contents("https://api.telegram.org/bot$key/deleteMessage?chat_id=$chanelId&message_id=$messageId");
				$message = "Id канала: " . $response['result']['chat']['id'];
			}else {
				$message = "Упс... Такого канала не существует или я не имею к нему доступа!";
			}

			$answer = file_get_contents("https://api.telegram.org/bot$key/sendMessage?chat_id=$chatId&text=$message");
		}

		return $answer;
	}
	public function __construct() {

	}
}