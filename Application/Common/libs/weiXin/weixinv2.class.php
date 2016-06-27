<?php
namespace Common\Libs\weiXin;
define(APPID, 'wx01881e098d8c9878');
define(APPSECRET,'d4d937a8a4ffa6370988384a2a9a77a2');
class WeiXinOAuthV2 {
	
	//获取用户信息
	public $scope;
	
	//获取access_token的URL
	function accessTokenURL() {
		return 'https://api.weixin.qq.com/sns/oauth2/access_token';
	}
	/**
	 * 用户授权url
	 */
	function authorizeURL() {
		return 'https://open.weixin.qq.com/connect/oauth2/authorize';
	}
	
	/**
	 * construct 是否获取用户信息
	 */
	function __construct($scope=true) {	
		if($scope)
		$this->scope='snsapi_userinfo';
		else
		$this->scope='snsapi_base';
	}
	
	/**
	 * authorize接口
	 * 获取微信账号登录验证页面地url
	 */
	function getAuthorizeURL($url , $state = NULL) {
		$params = array ();
		$params ['appid'] = APPID;
		$params ['redirect_uri'] = $url;
		$params ['response_type'] = 'code';
		$params ['scope'] = $this->scope;
		$params ['state'] = $state;
		$authorize=$this->authorizeURL () . "?" . http_build_query ( $params ).'#wechat_redirect';
		header("location",$authorize);
		//return $this->authorizeURL () . "?" . http_build_query ( $params ).'#wechat_redirect';;
	}
	
	/**
	
	 */
	function http($url, $data) {
		$ci = curl_init ();
		curl_setopt ( $ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0 );
		curl_setopt ( $ci, CURLOPT_USERAGENT, 'Sae T OAuth2 v0.1' );
		curl_setopt ( $ci, CURLOPT_CONNECTTIMEOUT, $this->connecttimeout );
		curl_setopt ( $ci, CURLOPT_TIMEOUT, $this->timeout );
		curl_setopt ( $ci, CURLOPT_RETURNTRANSFER, TRUE );
		curl_setopt ( $ci, CURLOPT_ENCODING, "" );
		curl_setopt ( $ci, CURLOPT_SSL_VERIFYPEER, FALSE );
		//curl_setopt($ci, CURLOPT_HEADERFUNCTION, array($this, 'getHeader'));
		curl_setopt ( $ci, CURLOPT_HEADER, FALSE );
		
		curl_setopt ( $ci, CURLOPT_POST, TRUE );
		curl_setopt ( $ci, CURLOPT_POSTFIELDS, $data );
		curl_setopt ( $ci, CURLOPT_URL, $url );
		curl_setopt ( $ci, CURLINFO_HEADER_OUT, TRUE );
		
		$ret = curl_exec ( $ci );
		
		curl_close ( $ci );
		return $ret;
	}
	
	/**
	 * 微信登录成功后的回调地址,主要保存access token
	 */
	function getAccessToken($code) {
		$token_url = $this->accessTokenURL ();//获取token地址
		$params = array();
		$params['appid'] = APPID;
		$params['secret'] = APPSECRET;
		$params['code'] = $code;
		$params['grant_type'] = 'authorization_code';

		$response = $this->http ( $token_url, http_build_query ( $params ) );
		$token = json_decode($response, true);		
		return $token;
	}
	
	/**
	 * 获取用户信息
	 * @param unknown_type $access_token
	 * @param unknown_type $uid
	 * @return Ambiguous
	 */
	function get_user_by_id($access_token, $uid) {
		$user_url = "https://api.weixin.qq.com/sns/userinfo";
		$params = array();
		$params['access_token'] = $access_token;
		$params['openid'] = $uid;
		$params['lang'] = 'zh_CN';
		$info = $this->http ( $user_url, http_build_query ( $params ) );
		$userinfo = json_decode ( $info, true );
		return $userinfo;
	}

}