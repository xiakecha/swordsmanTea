<?php
namespace Common\Libs\Log;
use Common\Libs\Log\LogManager;

define('FATAL_NO', 4096);
define('ERROR_NO', 1);

class ExceptionErrorDeal{
	
	public static function fatalError(){
		$lastError = error_get_last();
		if ($lastError == FATAL_NO) {
			LogManager::logBigData(FATAL_NO, $lastError['message'], $lastError['file'], $lastError['line']);
		}
	}
	
	public function exceptionError($exception) {
		LogManager::logBigData(ERROR_NO, $exception->getMessage(), $exception->getFile(), $exception->getLine());			
	    die();
	}
}