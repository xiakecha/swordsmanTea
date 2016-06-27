<?php
namespace Common\Libs\Client;
use Common\Libs\Client\AClient;
use Common\Libs\km\KmRpcService;

class KmMobile extends AClient{	
	
	private $_serverip;
	
	public function bs_device_login($arrParams){
		$this->_arrParams = $arrParams;
		if ($this->checkAuthority()) {
			parent::recordLoginStatus($arrParams['mac']);
			$this->_serverip = parent::getServerIp();
			return KmRpcService::ResponeResult(array(
				"cmdid"         => "D001",
	    		"chipid"		=> "",
	    		'mac'			=> "",
	    		"validatecode"	=> "",
	    		"serverip"		=> $this->_serverip."km_data_center/home_ktv/Services/Index/KmMobile",
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
