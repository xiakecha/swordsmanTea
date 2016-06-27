<?php
namespace Common\Libs\Client;
use Common\Libs\Client\AClient;
use Common\Libs\km\KmRpcService;

define('USER_AGENT_FIRMWARE_VERSION', 4);

class Mobile extends AClient{
	
	public function bs_device_login($arrParams){
		$this->_arrParams = $arrParams;
		if ($this->checkAuthority()) {
			parent::recordLoginStatus($arrParams['mac']);
			$this->_serverip = parent::getServerIp();
			return KmRpcService::ResponeResult(array(
	    		"chipid"		=> "",
	    		'mac'			=> $arrParams['mac'],
	    		"validatecode"	=> $arrParams['mac'],
	    		"serverip"		=> $this->_serverip."km_data_center/home_ktv/Services/Index/mobile_center",
			));
		}
	}

	public function checkAuthority(){
		$arrHeader = parent::getUserAgentArr();
	    if (!$arrHeader || count($arrHeader) < USER_AGENT_FIRMWARE_VERSION) {
	       return KmRpcService::ResponeResult(KmRpcService::error(401, "没有授权！"));
	    }
		return true;
	}

}
