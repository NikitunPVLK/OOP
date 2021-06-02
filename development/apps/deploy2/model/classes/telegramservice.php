<?php

namespace model\classes;

class TelegramService implements \Model\Interfaces\Service {

    function Send(Post $post):bool {
		$chat = $post->getId();
		$key = ''; // Ключ API телеграм
		
		if(!isset($key) || empty($key)){
			throw new \Exception('INCORRECT_TELEGRAM_TOKEN');
		}

		if(!isset($chat) || empty($chat)) {
			throw new \Exception('INCORRECT_CHAT_ID');
		}

		$text = urlencode($post->toString());
        $attachment = $post -> getAttachment();

		if(empty($attachment['name']) && !empty($text)){
			$answer = file_get_contents("https://api.telegram.org/bot$key/sendMessage?parse_mode=markdown&chat_id=$chat&text=$text");
        	$answer = json_decode($answer, true);
			return true; 
		}
		$text = urlencode($post->getTitle() . "\n" . $post->getText());
		$attachmentName = $attachment['name'];
		$attachmentTmpName = $attachment['tmp_name'];
		$attachmentType = $attachment['type'];
		$attachmentContent = file_get_contents($attachmentTmpName);
	
		if($attachment['type']  == 'image/jpeg' || $attachment['type'] == "image/png"){
			define('MULTIPART_BOUNDARY', '--------------------------'.microtime(true));
			define('FORM_FIELD', 'photo'); 
			$content =  "--".MULTIPART_BOUNDARY."\r\n".
				"Content-Disposition: form-data; name=\"".FORM_FIELD."\"; filename=\"".$attachmentName."\"\r\n".
				"Content-Type: ".$attachmentType."\r\n\r\n".
				$attachmentContent."\r\n";
			$content .= "--".MULTIPART_BOUNDARY."\r\n".
				"Content-Disposition: form-data; name=\"chat_id\"\r\n\r\n".
				$chat."\r\n";
			$content .= "--".MULTIPART_BOUNDARY."--\r\n";
			$context = stream_context_create(array(
				'http' => array(
					'method' => 'POST',
					'header' => 'Content-Type: multipart/form-data; boundary='.MULTIPART_BOUNDARY,
					'content' => $content,
				)
			));
			
			$answer = file_get_contents("https://api.telegram.org/bot$key/sendPhoto?caption=$text", false, $context);
		}

		else{
			define('MULTIPART_BOUNDARY', '--------------------------'.microtime(true));
			define('FORM_FIELD', 'document'); 
			$content =  "--".MULTIPART_BOUNDARY."\r\n".
				"Content-Disposition: form-data; name=\"".FORM_FIELD."\"; filename=\"".$attachmentName."\"\r\n".
				"Content-Type: ".$attachmentType."\r\n\r\n".
				$attachmentContent."\r\n";
			$content .= "--".MULTIPART_BOUNDARY."\r\n".
				"Content-Disposition: form-data; name=\"chat_id\"\r\n\r\n".
				$chat."\r\n";
			$content .= "--".MULTIPART_BOUNDARY."--\r\n";
			$context = stream_context_create(array(
				'http' => array(
					'method' => 'POST',
					'header' => 'Content-Type: multipart/form-data; boundary='.MULTIPART_BOUNDARY,
					'content' => $content,
				)
			));
			$answer = file_get_contents("https://api.telegram.org/bot$key/sendDocument?caption=$text", false, $context);
		}
        
		return true;
    }
}