<?php
/**
 * Core bootloader
 *
 * @author Serhii Shkrabak
 */

/* RESULT STORAGE */
$RESULT = [
	'state' => 0,
	'data' => [],
	'message' => []
];

/* ENVIRONMENT SETUP */
define('ROOT', $_SERVER['DOCUMENT_ROOT'] . '/'); // Unity entrypoint;

register_shutdown_function('shutdown', 'OK'); // Unity shutdown function

spl_autoload_register('load'); // Class autoloader

set_exception_handler('handler'); // Handle all errors in one function

/* HANDLERS */

/*
 * Class autoloader
 */

function load (String $class):void {
	$class = strtolower(str_replace('\\', '/', $class));
	$file = "$class.php";
	if (file_exists($file))
		include $file;

}

/*
 * Error logger
 */
function handler (Throwable $e):void {
	global $RESULT;
	$codes = ['RESOURCE_LOST' => 4, 'INTERNAL_ERROR' => 6, 'INCORRECT_TELEGRAM_TOKEN' => 7];
	$message = $e -> getMessage();
	$RESULT['state'] = (isset($codes[$message])) ? $codes[$message] : 6;
	$RESULT[ 'message' ][] = [
		'type' => get_class($e),
		'details' => $message,
		'file' => $e -> getFile(),
		'line' => $e -> getLine(),
		'trace' => $e -> getTrace()
	];
		
}
/*
 * Shutdown handler
 */
function shutdown():void {
	global $RESULT;
	$error = error_get_last();
	if ( ! $error ) {
		header("Content-Type: application/json");
		echo json_encode($GLOBALS['RESULT'], JSON_UNESCAPED_UNICODE);
		//readfile(ROOT.'/static/index.html');
	}
}

$CORE = new Controller\Main;
try{
	$data = $CORE->exec();
	$RESULT['data'] = $data;
}catch(Exception $e){
	handler($e);
	unset($RESULT['data']);
}