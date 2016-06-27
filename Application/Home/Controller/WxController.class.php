<?php
namespace Home\Controller;
use Think\Controller;
use Common\libs\wechat\WeCheck;
abstract class WxController extends Controller {
	private $app_id = 'wx01881e098d8c9878';//公众号ID
	private $app_secret = 'd4d937a8a4ffa6370988384a2a9a77a2';//公众号安全证书
	/*微信授权函数
	 * 参数一：授权成功后返回的url,
	 * 参数二：是否获取用户信息*/
	public function authorize($redirect_uri, $bGetUserinfo){
		//基础认证step1
		if ($bGetUserinfo){
			$scope='snsapi_userinfo';
		}else{
			$scope='snsapi_base';
		}
		$url  = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->app_id.'&redirect_uri='
		.urlencode($redirect_uri).'&response_type=code&scope='.$scope
		.'#wechat_redirect';
		header("Location:".$url);
	}

	/* 根据authorize方法得到参数code
	 * 调用get_access_token（$code)得到token数组
	 * token数组       key             含义
                 access_token	   网页授权接口调用凭证
                 expires_in	     access_token接口调用凭证超时时间，单位（秒）
                 refresh_token	   用户刷新access_token
                 openid	                         用户唯一标识，用户和公众号唯一的OpenID
                 scope	                         用户授权的作用域，使用逗号（,）分隔
                 unionid	只有在用户将公众号绑定到微信开放平台帐号后，才会出现该字段。详见：获取用户个人信息（UnionID机制）*/
	public function get_access_token($code)
	{
	    //url分行出错
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".
		"$this->app_id&secret=$this->app_secret&code=$code&grant_type=authorization_code";
	    $result = $this->https_request($url);
	    $jsoninfo = json_decode($result, true);
	    return $jsoninfo;
	}

	/**
	 * 获取授权后的微信用户信息
	 * @param string $access_token
	 * @param string $open_id
	 *返回数组              key                 values
	 *          nickname               昵称
	 *          sex                    1：女，2：男，0：未知
	 *          headimgurl              头像
	 */
	public function get_user_info($access_token = '', $open_id = '')
	{
		if($access_token && $open_id)
		{
			$info_url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$open_id}&lang=zh_CN";
			$info_data = $this->http($info_url);
			return json_decode($info_data, TRUE);
		}

		return FALSE;
	}

	private function https_request($url,$data = null){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		if (!empty($data)){
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		curl_close($curl);
		  return $output;
    }
}