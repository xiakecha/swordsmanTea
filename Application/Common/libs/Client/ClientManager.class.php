<?php
namespace Common\Libs\Client;
use Common\Libs\Client;
use Common\Libs\km\Utils;


define('CLIENT_IDENTIFY_KMBOX', 'kmbox');
define('CLIENT_IDENTIFY_SBOX', 's69');
define('CLIENT_IDENTIFY_THIRDAPP', 'app_third');
define('CLIENT_IDENTIFY_ESINGMOYUN', 'esingmoyun');
define('CLIENT_IDENTIFY_KMMOBILE_IPHONE', 'iphone');
define('CLIENT_IDENTIFY_KMMOBILE_IPAD', 'ipad');
define('CLIENT_IDENTIFY_ESING_THIRD', 'esing_third');

class ClientManager{
	
	/** 
	  * 请求 一个客户端对象
	  * @param string $strUserAgent  设备发送的user-agent信息
	  * @return obj
	 */	
	static $arrHeader;
	public static function getClientHandle(){
		$strUserAgent = Utils::getCustomHeaderValue("User-Agent");
	    self::$arrHeader = explode('/', $strUserAgent);   
	    self::$arrHeader = array_map('strtolower', self::$arrHeader);
	    switch (true) {
	        case self::isKmbox():
	        	return new Kmbox();
	        	
	        case self::isSbox():
	        	return new Sbox();
	        	
	        case self::isAppThird():
	        	return new ThirdApp();
	        	
			case self::isEsingMoyun():   
	        	return new EsingMoyun();
	        	 
	        case self::isKmMobile():   
	        	return new KmMobile();
	        	
	        case self::isEsingThird():     		        	
	            return new EsingThird();	                 	                       
	    }	    	
	}

	public static function isKmbox(){
		if (self::$arrHeader['0'] == CLIENT_IDENTIFY_KMBOX && 
			self::$arrHeader['3'] != CLIENT_IDENTIFY_KMMOBILE_IPHONE && 
			self::$arrHeader['3'] != CLIENT_IDENTIFY_KMMOBILE_IPAD) {
				return true;
		}
		return false;		
	}
	
	public static function isSbox(){
		if (self::$arrHeader['0'] == CLIENT_IDENTIFY_SBOX && 
			self::$arrHeader['3'] != CLIENT_IDENTIFY_KMMOBILE_IPHONE && 
			self::$arrHeader['3'] != CLIENT_IDENTIFY_KMMOBILE_IPAD) {
				return true;
		}
		return false;	
	}
		
	public static function isAppThird(){
		return self::$arrHeader['0'] == CLIENT_IDENTIFY_THIRDAPP ? true : false;
	}

	public static function isEsingMoyun(){
		return  self::$arrHeader['0'] == CLIENT_IDENTIFY_ESINGMOYUN ? true : false;
	}
	
	public static function isKmMobile(){
		if (self::$arrHeader['0'] == CLIENT_IDENTIFY_KMBOX && 
			(self::$arrHeader['3'] == CLIENT_IDENTIFY_KMMOBILE_IPHONE || 
			 self::$arrHeader['3'] == CLIENT_IDENTIFY_KMMOBILE_IPAD)) {
				return true;
		}
		return false;
	}
	
	public static function isEsingThird(){
		if (self::$arrHeader['0'] == CLIENT_IDENTIFY_ESING_THIRD){
				return true;
		}
		return false;
	}
		
}
