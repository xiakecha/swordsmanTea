<?php
namespace Common\Libs\Client;
use Common\Libs\Client\AClient;
use Common\Libs\km\KmRpcService;

class Kmbox extends AClient{	
	public function bs_device_login($arrParams){
		$this->_arrParams = $arrParams;
		if ($this->checkAuthority()) {
			parent::recordLoginStatus($arrParams['mac']);
			$this->_serverip = parent::getServerIp();
			return KmRpcService::ResponeResult(array(
	    		"chipid"		=> "",
	    		'mac'			=> $arrParams['mac'],
	    		"validatecode"	=> $arrParams['mac'],
	    		"serverip"		=> $this->_serverip."km_data_center/home_ktv/Services/Index/kmBox",
			));
		}
	}
	
	public function checkAuthority(){
		$arrHeader = parent::getUserAgentArr();
	    if (!$arrHeader) {
	        return KmRpcService::ResponeResult(KmRpcService::error(401, "没有授权！"));
	    }
		return true;
	}
}
