<?php
namespace Common\Libs\Log;
use Common\Libs\km\Utils;
use Common\Libs\Log\Log;

//记录BUG大数据的Logger
define('LOGGER_BIGDATA_BUG', 'kmBug');

define('CLIENT_CODE', 'DC.ClientRequest.');

define('SERVER_CODE', 'DC.ServerBug.');

class LogManager{

	static $cmdid;
		
	 /**
	   * 大数据
	   * @param integer $errno   错误码
	   * @param string  $errstr  错误字符串
	   * @param string  $errfile 错误文件
	   * @param integer $errline 错误行号
	  */
    public static function logBigData($errno, $errstr, $errfile, $errline){    
    	$log = new Log(LOGGER_BIGDATA_BUG);
    	
    	$errMessage = json_encode('['.$errno.']'.$errstr ." in file ". $errfile." at line ". $errline);	
		$errMessage = self::errMessageformat($errMessage);     
				
		switch ($errno) {
			case E_NOTICE:
			  $logLevel = 'debug';
			  break;
			  
			case E_WARNING:
			  $logLevel = 'warn';
			  break;
			  			 
			case E_ERROR || E_DEPRECATED || E_USER_ERROR:
			  $logLevel = 'error';
			  $log->setToEmail(false);
			  break;
			  			 
			case E_RECOVERABLE_ERROR:
			  $logLevel = 'fatal';
			  $log->setToEmail(false);
			  break;				
		};
		
		$logMsgArr = array(
 						   'DateTime' => date('Y:m:d H:i:s', time()),
 						   'ServerIP' => Utils::getHostUrl(),
 						   'ClientIP' => getClientIP(),
 						        'PID' => getmypid(),
 						  'RequestID' => self::$cmdid,
							  'Level' => $logLevel,				
    	 					   'Type' => 'unknow',							 			  
 							'Message' => $errMessage,
 						 	   'Code' => SERVER_CODE.self::$cmdid
 						);
 		$logmsgStr = implode(' | ', $logMsgArr);	
 		
 		$log->setlogstr($logmsgStr);
 		$log->setlogLevel($logLevel);
 		$log->runLog();
 		
	}
         
     /**
	   * 记录客户端请求数据
	   * @param string $cmdid 客户端请求
	  */     
     public static function logClientRequest($arrParams){ 
     	$strUserAgent = Utils::getCustomHeaderValue('User-Agent');
        $strdevicetag = Utils::getCustomHeaderValue('devicetag'); 
        $arrParams = array_map('urlencode', $arrParams);
        $jsonParams = json_encode($arrParams);
        $jsonParams = self::errMessageformat($jsonParams);
      	$logMsgArr = array(
 						   'DateTime' => date('Y:m:d H:i:s', time()),
 						   'ServerIP' => Utils::getHostUrl(),
 						   'ClientIP' => getClientIP(),
 						        'PID' => getmypid(),
 						  'RequestID' => self::$cmdid,
 							  'Level' => 'info',
 							   'Type' => 'unknow',
 							'Message' => $jsonParams,
 						 	   'Code' => CLIENT_CODE.self::$cmdid,
       				 	 'User-Agent' => $strUserAgent,
      					   'devicetag'=> $strdevicetag
 						);
	 		       
  		$logmsgStr = implode(' | ', $logMsgArr);		
  		$log = new Log();
  		$log->setlogstr($logmsgStr);
		$log->runLog();
     } 
     
     public static function errMessageformat($errMessage){
     	if (substr_count($errMessage, '%') > 1) {
    		 $errMessage = urldecode($errMessage);
    	}  
    	return $errMessage;		
     }

     
     
}