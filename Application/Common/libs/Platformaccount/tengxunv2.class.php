<?php
/**
 * PHP SDK for weibo.com (using OAuth2)
 * 
 * @author Elmer Zhang <freeboy6716@gmail.com>
 */

/**
 * @ignore
 */
//class OAuthException extends Exception {
//	// pass
//}

/**
 * 新浪微博 OAuth 认证类(OAuth2)
 *
 * 授权机制说明请大家参考微博开放平台文档：{@link http://open.weibo.com/wiki/Oauth2}
 *
 * @package sae
 * @author Elmer Zhang
 * @version 1.0
 */
class TengXunOAuthV2 {
	/**
	 * @ignore
	 */
	public $client_id;
	/**
	 * @ignore
	 */
	public $client_secret;
	/**
	 * @ignore
	 */
	public $access_token;
	/**
	 * @ignore
	 */
	public $refresh_token;

	/**
	 * Set timeout default.
	 *
	 * @ignore
	 */
	public $timeout = 30;
	/**
	 * Set connect timeout.
	 *
	 * @ignore
	 */
	public $connecttimeout = 30;
	/**
	 * print the debug info
	 *
	 * @ignore
	 */
	public $debug = FALSE;
	
	public $scope = "get_user_info,add_share,add_one_blog,add_t";
	
	/**
	 * Set API URLS
	 */
	/**
	 * @ignore
	 */
	function accessTokenURL() {
		return 'https://graph.qq.com/oauth2.0/token';
	}
	/**
	 * @ignore
	 */
	function authorizeURL() {
		return 'https://graph.qq.com/oauth2.0/authorize';
	}
	
	/**
	 * construct WeiboOAuth object
	 */
	function __construct($client_id, $client_secret, $access_token = NULL, $refresh_token = NULL) {
		$this->client_id = $client_id;
		$this->client_secret = $client_secret;
		$this->access_token = $access_token;
		$this->refresh_token = $refresh_token;
	}
	
	/**
	 * authorize接口
	 * 获取腾讯qq账号登录验证页面地url
	 */
	function getAuthorizeURL($url, $response_type = 'code', $state = NULL, $display = NULL) {
		$params = array ();
		$params ['client_id'] = $this->client_id;
		$params ['redirect_uri'] = $url;
		$params ['response_type'] = $response_type;
		$params ['state'] = $state;
		$params ['display'] = $display;
		$params ['scope'] = $this->scope;
		return $this->authorizeURL () . "?" . http_build_query ( $params );
	}
	
	/**
	 * Make an HTTP request
	 * @param unknown_type $url
	 * @param unknown_type $data
	 * @return Ambiguous
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
	 * QQ登录成功后的回调地址,主要保存access token
	 */
	function getAccessToken( $type="code", $keys ) {
		$token_url = $this->accessTokenURL ();//获取token地址
		$params = array();
		$params['grant_type'] = 'authorization_code';
		$params['client_id'] = $this->client_id;
		$params['redirect_uri'] = $keys["redirect_uri"];
		$params['client_secret'] = $this->client_secret;
		$params['code'] = $keys["code"];
		
		//$response = file_get_contents($token_url);
		$response = $this->http ( $token_url, http_build_query ( $params ) );
		//var_dump($response); return ;
		if (strpos ( $response, "callback" ) !== false) {
			$lpos = strpos ( $response, "(" );
			$rpos = strrpos ( $response, ")" );
			$response = substr ( $response, $lpos + 1, $rpos - $lpos - 1 );
			$msg = json_decode ( $response );
			if (isset ( $msg->error )) {
				$error = "<h3>error:</h3>" . $msg->error;
				$error .= "<h3>msg  :</h3>" . $msg->error_description;
				throw new OAuthException($error);
			}
		}
		//获取返回的access_token信息
		$token = array ();
		parse_str ( $response, $token );
		
		return $token;
	}
	
	/**
	 * 获取用户的uid
	 * @param unknown_type $access_token
	 * @throws OAuthException
	 */
	function get_uid($access_token) {
		$graph_url = "https://graph.qq.com/oauth2.0/me";
		$param = "access_token=" . $access_token;
		$str = $this->http ( $graph_url, $param );
		
		if (strpos ( $str, "callback" ) !== false) {
			$lpos = strpos ( $str, "(" );
			$rpos = strrpos ( $str, ")" );
			$str = substr ( $str, $lpos + 1, $rpos - $lpos - 1 );
		}
		
		$user = json_decode ( $str );
		if (isset ( $user->error )) {
			$error = "<h3>error:</h3>" . $user->error;
			$error .= "<h3>msg  :</h3>" . $user->error_description;
			throw new OAuthException($error);
		}
		
		return $user;
	}
	
	/**
	 * 获取用户信息
	 * @param unknown_type $access_token
	 * @param unknown_type $uid
	 * @return Ambiguous
	 */
	function get_user_by_id($access_token, $uid) {
		$user_url = "https://graph.qq.com/user/get_user_info";
		$params = array();
		$params['access_token'] = $access_token;
		$params['oauth_consumer_key'] = $this->client_id;
		$params['openid'] = $uid;
		$params['format'] = 'json';
		
		$info = $this->http ( $user_url, http_build_query ( $params ) );
		//return $info;
		$userinfo = json_decode ( $info, true );
		
		return $userinfo;
	}

}
?>