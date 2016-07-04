<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	private $app_id = 'wxb6fb2f3d69e59dcd';//公众号ID
	private $app_secret = 'ba3ed9557e5b99777c4e59110abf69a4';//公众号安全证书


	private function GetSignPackage(){
		require_once "jssdk.php";
		$jssdk = new \JSSDK("wxb6fb2f3d69e59dcd", "ba3ed9557e5b99777c4e59110abf69a4");
		$signPackage = $jssdk->GetSignPackage();
		return $signPackage;
	}
	public function index(){
		$appid = "wxb6fb2f3d69e59dcd";
		$snsapi="snsapi_base";
		$redir_url = urlencode("http://xgftea.hongweipeng.com/index.php/Home/Index/set_display");
		$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='
		.$redir_url.'&response_type=code&scope='.$snsapi.'&state=STATE#wechat_redirect';
		redirect($url);
	}

	public  function set_display(){
		$code = I('code');//前端传来的code值
		if(empty($code)){
			echo"<script>alert('请授权！');history.go(-1);</script>";
			return ;
		}
		$jsoninfo = $this->get_access_token($code);
		$openid = $jsoninfo["openid"];//从返回json结果中读出openid
		S('openid',$openid);
		$sign = $this->GetSignPackage();
		$this->assign('share_wx',$sign);
		$this->display('Index/reduce');
	}
	public function homepage(){
		$sign = $this->GetSignPackage();
		$this->assign('share_wx',$sign);
		$this->display('Index/index');
	}

	public function changeCut(){
		$image=I('image');
		//$image=substr($image,22)."=";
		$openid=S('openid');
		$time=date('Y-m-d H:i:s');
		$dateTime=strtotime($time);
		$image = base64_decode(substr($image, 22));
		header('Content-Type: image/png');
		$createImage=$openid.".png";
		$titleNew = $openid.md5($head.date('YmdHis')).".png";
		S('title',$titleNew);
		$url="/upload/".$titleNew;
		$filename =  "./Public/upload/".$titleNew;
		$fp = fopen($filename, 'w');
		fwrite($fp, $image);
		fclose($fp);
		$this->ajaxReturn(array('errorCode' => 0, 'url' =>"$url)"), 'json');
		return "ajaxReturn";
	}

	public function createPoster(){
		$openid=S('openid');;
		$contents=array();
		$type=I('type');
		$material=I('material');
		$contents[4]=I('foot');
		$contents[5]=S("title");
		if (!$openid) {
			$openid = I('openid');
		}
		if(!$contents[5]){
			$contents[5] = I('title');
		}
		if(empty($contents[5])){
			return;
		}
		if(empty($openid)){
			return;
		}
		$table=M('order_list');
		$User = M("order_list");
		$User->where('type=2')->select();
		$table->lock(true);//锁表
		$dateTime = date('Y-m-d H:i:s');
		$data['openid'] = $openid;
		$data['createTime'] = $dateTime;
		$data['postImage']=$contents[5];
		$data['contents']=$contents[4];
		$data['type']=$type;
		$data['material']=$material;
		$table->add($data);
		$table->lock(false);//解锁表
		if($type==1){
			$type="水仙";
		}
		else{
			$type="肉桂";
		}
		$this->assign("con",$contents);
		$this->assign("type",$type);
		$this->assign("material",$material);
		$sign = $this->GetSignPackage();
		$this->assign('share_wx',$sign);
		$this->assign('openid',$openid);
		$this->display("Index/poster");
	}
	public function changeSrc(){
		$image=I('image');
		//$image=substr($image,22)."=";
		//dump($image);
		$openid=S('openid');
		$time=date('Y-m-d H:i:s');
		$dateTime=strtotime($time);
		$image = base64_decode(substr($image, 22));
		header('Content-Type: image/png');
		$createImage=$openid.$dateTime."2.png";
		S('createImage',$createImage);
		$url="/upload/".$createImage;
		$filename =  "./Public/upload/".$createImage;
		$fp = fopen($filename, 'w');
		fwrite($fp, $image);
		fclose($fp);
		$table=M('order_list');
		$title=S('title');
		$table->where("postImage='$title'")->setField('createImage',$createImage);
		$this->ajaxReturn(array('errorCode' => 0, 'url' =>"$url)",'createImage' => "$createImage"), 'json');
		return "数据库更新了createImg";
	}
	public function showPoster(){
		$openid=S('openid');
		$createImage=S('createImage');
		$sign = $this->GetSignPackage();
		$pieces=S('pieces');
		S('pieces',null);
		$this->assign('share_wx',$sign);
		$this->assign('openid',$createImage);
		$this->assign('pieces',$pieces);
		$this->display("Index/showPoster");
		return "showPoster";
	}
	public function  imgCut(){
		$this->display("Index/imgCut");
	}
	public function reduce(){
		//phpinfo();
		//dump("sss");
		S("openid","1");
		$this->display("Index/reduce");
		return "reduce";
	}

	public function phpinfos(){
		phpinfo();
	}

	public function showSword(){
		phpinfo();
		$this->display("Index/showSword");
		return "showSword";
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



