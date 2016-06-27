<?php
namespace Home\Controller;
use Think\Controller;
class RedirectiveController extends Controller {
	public function index($flag=null) {
		$code = I('code');
		$state = I('state');
		if($flag == 1 ){
			$url = "http://bbs.evideostb.com/forum.php";
			header("Location:".$url);
		}else if($flag == 2){
			$url = "http://120.25.159.91/km_data_center/home_ktv/Home/Register/wxbind?code=". $code."&state=".$state;
			header("Location:".$url);
		}else if($flag == 3){
			$url = "http://120.25.159.91/km_data_center/home_ktv/Home/Register/wxBaseCallback?code=". $code."&state=".$state;
			header("Location:".$url);
		}
		//微信认证入口
		//$this->authorize("http://activity.evideostb.com/activity/Home/Crowdfunding/set_display",false);
	}

}



