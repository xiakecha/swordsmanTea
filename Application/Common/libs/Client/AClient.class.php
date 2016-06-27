<?php
namespace Common\Libs\Client;
use Common\Libs\km\Utils;
use Common\Libs\km\KmConfig;

abstract class AClient{
	const USER_AGENT_CLIENT_TYPE = 0;
    const USER_AGENT_SOFT_VERSION = 1; 
    const USER_AGENT_PROTO_VERSION = 2;
    
	abstract public function bs_device_login($arrParams);   
	abstract public function checkAuthority();
	
	public function recordLoginStatus($mac){	
		$data['ChipID']        = $this->getDevicetag();
		$data['Mac']           = $mac;
		$count = M('kmesing.esing_device_login')->where($data)->count();
		if ($count > 0) {
			$update['LastLoginTime'] = date('Y-m-d H:i:s', time());
			M('kmesing.esing_device_login')->where($data)->save($update);
		}else {
			$data['LastLoginIP']   = $_SERVER['REMOTE_ADDR'];
			$data['Type']          = $this->getProducttypeToNum();
			$data['DeviceVersion'] = $this->getSoftwareversion();
			M('kmesing.esing_device_login')->add($data);
		}		
	}
	
	public function getUserAgentArr(){
		$strUserAgent = Utils::getCustomHeaderValue("User-Agent");
		$arrHeader = explode('/', $strUserAgent);
		return $arrHeader;
	}
	
	public function getProducttype(){
		$userAgentArr = $this->getUserAgentArr();	
		return $userAgentArr['0'];
	}
	
	public function getSoftwareversion(){
		$userAgentArr = $this->getUserAgentArr();
		return $userAgentArr['1'];
	}
	
	public function getDevicetag(){
		return Utils::getCustomHeaderValue('devicetag');
	}
	
	/*
	 * 获取客户端所用曲库标记
	 * return int
	 */

	const CLIENT_IDENTIFY_KMMOBILE_IPHONE = 'iphone';
    const CLIENT_IDENTIFY_KMMOBILE_IPAD = 'ipad';
	
	public function getClientSongResource(){
		$userAgentInfo = $this->getUserAgentArr();

		
		$where['b.client_flg'] = $userAgentInfo['0'];
		if ($userAgentInfo['0'] == self::CLIENT_IDENTIFY_KMBOX){
			switch ($userAgentInfo['3']){
				case self::CLIENT_IDENTIFY_KMMOBILE_IPHONE:
					 $where['b.client_flg'] = self::CLIENT_IDENTIFY_KMMOBILE_IPHONE;
					 break;
					 
				case self::CLIENT_IDENTIFY_KMMOBILE_IPAD:
					 $where['b.client_flg'] = self::CLIENT_IDENTIFY_KMMOBILE_IPAD;
					 break;				
			}
		} 
		$where['a.status'] = 1;
		$where['b.status'] = 1;
		$where['c.status'] = 1;
		$resource = M('kmadmin.client_song_resource')->alias('a')
													 ->join('kmesing.km_tbl_client b on a.client_id = b.client_id')
													 ->join('kmadmin.km_tbl_song_lib c on a.lib_id = c.lib_id')
													 ->where($where)
													 ->field('a.lib_id')
													 ->find();
		return $resource['lib_id'];
	}
	
	/*
	 * 是否属于灰度设备
	 * return 0|1
	 */
	public function checkIsGrayDevice() {
		$device_id = Utils::getCustomHeaderValue('devicetag');
		$pMDLAdminGrayLevel = new \Model\AdminGrayLevelModel();
		return $pMDLAdminGrayLevel->isGrayDevice($device_id);
	}
	
	const CLIENT_IDENTIFY_ESINGMOYUN = 'esingmoyun';
	const TYPE_NUM_ESINGMOYUN = 0;
	const CLIENT_IDENTIFY_KMBOX = 'kmbox';
	const TYPE_NUM_KMBOX = 1;
	const CLIENT_IDENTIFY_SBOX  = 's69';
	const TYPE_NUM_SBOX = 2;
	const CLIENT_IDENTIFY_THIRDAPP = 'app_third';
	const TYPE_NUM_THIRDAPP = 3;
	
	public function getProducttypeToNum() {
		$typename = $this->getProducttype();
		switch ($typename) {
			case self::CLIENT_IDENTIFY_ESINGMOYUN:
				return self::TYPE_NUM_ESINGMOYUN;
				
			case self::CLIENT_IDENTIFY_KMBOX:
				return self::TYPE_NUM_KMBOX;
				
			case self::CLIENT_IDENTIFY_SBOX:
				return self::TYPE_NUM_SBOX;
				
			case self::CLIENT_IDENTIFY_THIRDAPP:
				return self::TYPE_NUM_THIRDAPP;	
			default:
				return self::TYPE_NUM_ESINGMOYUN;
		}
	}
	
	/*
	 * 获取的音准文件下载地址【公用的获取erc文件下载地址方法】
	 * @param string $songid 歌曲ID
	 * return array
	 */
	public function getSoundaccuracyUrl($songid) {		
		$pMDLsoundaccuracy = new \Model\SoundaccuracyModel();
		$arrSoundAccuracyInfo = $pMDLsoundaccuracy->getSource($songid);
		
		$strErc = "0";
		if ($arrSoundAccuracyInfo && isset($arrSoundAccuracyInfo['features_fileid_b'])) {
			$strErc = $arrSoundAccuracyInfo['features_fileid_b'];
		}
	
        $strErcUrl = '';
		$strErcType = '-1';
		if ($strErc > '0') {
			$strUrlHead = KmConfig::file_url_head();
			$strUrlHead = $strUrlHead.'?fileid=';
			$strErcUrl = $strUrlHead.$strErc ;
			$strErcType = '0';
		}
		
		return array( 
						"subtitleurl" => $strErcUrl,
                        "subtitletype" => $strErcType, 
					);		
	}
	
	/*
	 * 负载均衡
	 */
	public function getServerIp() {
		if ($this->checkIsGrayDevice()) {
			return C('GRAY_SERVICES');
		}else {
			$area = mt_rand(1, 100);
			foreach (C('BALANC_SERVICES') as $balancInfo) {				
				if ($area <= $balancInfo['area']) {
					return $balancInfo['serverIp'];
				}
			}
		}
	}
	
	
		
}
