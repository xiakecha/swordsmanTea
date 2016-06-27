<?php
namespace Common\Libs\Log;
use Common\Libs\km\Utils;
use Common\Libs\Utils\CommonUtils;

Vendor('CommonLog.Logger');

class Log{
	 private $_logstr;
	 private $_logger;
	 
	 private $_ToFile  = true;
	 private $_ToEmail = false;
	 private $_logLevel = 'info';
	 private $_emailAddr = array('chenbing.sy@star-net.cn');
	 
	 /*邮件默认设置*/
	 private $_emailInfo = array(
	 							  'host' => 'mail.star-net.cn',
	 							  'smtpauth' => false,
	 							  'mail_from' => 'chenbing.sy@star-net.cn',
	 							  'mail_fromname' => 'chenbing.sy',
	 							  'subject' => '服务器端BUG', 
	 							);
	
	 /*
	  * 初始化一个配置logger
	  * @param string $logger 配置名称
	  */
	 public function __construct($logger = 'kmClientRequest'){
	 	$this->_logger = $logger;
	 }
	 
 	 /*$flag 值 TRUE|FALSE*/
	 public function setToFile($flag){
	 	$this->_ToFile = $flag;
	 }
	 
	 /*$flag 值 TRUE|FALSE*/
	 public function setToEmail($flag){
	 	$this->_ToEmail = $flag;
	 }
	
	 public function setlogLevel($logLevel){
	 	$this->_logLevel = $logLevel;
	 }
	 
	 public function setlogstr($logstr){
	 	$this->_logstr = $logstr;
	 }
	 
	 public function setemailAddr($emailAddr){
	 	$this->_emailAddr = $emailAddr;
	 }
	 
	 public function setemailInfo($emailInfo){
	 	$this->_emailInfo = $emailInfo;
	 }
	 
	 
     public function runLog() {
     	if ($this->_ToFile) {
     		$this->toFile();
     	}
     	
     	if ($this->_ToEmail) {
     		$this->toEmail();
     	}
     }
     
	 public function toFile(){ 
     	\Logger::configure(dirname(__FILE__).'/LogtoFileConfig.xml'); 
     	$log = \Logger::getLogger($this->_logger);	    	
     	$logLevel  =  $this->_logLevel; 
     	$loglogstr =  $this->_logstr; 
		$log->$logLevel($loglogstr); 
     } 
    
     public function toEmail(){
     	C('MAIL_HOST',     $this->_emailInfo['host']);
    	C('MAIL_SMTPAUTH', $this->_emailInfo['smtpauth']);
    	C('MAIL_FROM',     $this->_emailInfo['mail_from']);
    	C('MAIL_FROMNAME', $this->_emailInfo['mail_fromname']);
      	
    	foreach ($this->_emailAddr as $emailStr) {
    		CommonUtils::sendMail($emailStr, $this->_emailInfo['subject'], $this->_logstr);
    	}    
     }
}