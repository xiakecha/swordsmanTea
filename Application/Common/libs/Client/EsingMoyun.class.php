<?php
namespace Common\Libs\Client;
use Common\Libs\Client\AClient;
use Common\Libs\km\Utils;
use Common\Libs\km\KmRpcService;

class EsingMoyun extends AClient{
	
	private $_arrParams;
	private $_serverip;
	 
	public function bs_device_login($arrParams){
		$this->_arrParams = $arrParams;
		if ($this->checkAuthority()) {
			parent::recordLoginStatus($arrParams['mac']);
			$this->_serverip = parent::getServerIp();
			return KmRpcService::ResponeResult(array(
	    		"chipid"		=> "",
	    		'mac'			=> $arrParams['mac'],
	    		"validatecode"	=> $arrParams['mac'],
	    		"serverip"		=> $this->_serverip."km_data_center/home_ktv/Services/Index/EsingMoyun",
			));
		}
	}
	
	public function checkAuthority(){
		$pEsingDeviceModel = new \Model\EsingDeviceModel();
		$chipid = strtoupper(Utils::getCustomHeaderValue("devicetag"));
		$mac    = $this->_arrParams['mac'];
		$mac    = formatMac($mac);
	    if (!$pEsingDeviceModel->isBind($chipid, $mac)) {
	        return KmRpcService::ResponeResult(KmRpcService::error(401, "没有授权！"));
	        exit;
	    }
		return true;
	}	
	
	/*
	 * 获取的音准文件下载地址【单机魔云独有的获取erc文件下载地址方法】
	 * @param string $songid 歌曲ID
	 * return array
	 */
	public function getSoundaccuracyUrl($songid) {	
		$soundaccuracyfileurl = '';	
	    $pMDLEsingsoundaccuracyCdn = new \Model\EsingsoundaccuracyCdnModel();
		$soundaccuracyfileurl =  $pMDLEsingsoundaccuracyCdn->getSoundAccuracyFileUrl($songid);
		
		$strErcType = '-1';	
		if ($soundaccuracyfileurl) {
			$strErcType = '0';			
		}
			
		return array(
						"subtitleurl"  => $soundaccuracyfileurl,
                        "subtitletype" => $strErcType, 
					);	
	}
}
