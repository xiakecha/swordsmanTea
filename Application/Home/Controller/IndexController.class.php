<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends WxController {
	private function GetSignPackage(){
		require_once "jssdk.php";
		$jssdk = new \JSSDK("wxb6fb2f3d69e59dcd", "ba3ed9557e5b99777c4e59110abf69a4");
		$signPackage = $jssdk->GetSignPackage();
		return $signPackage;
	}
	public function index($flag=null){
		$this->authorize("http://101.201.111.74/index.php/Home/Index/set_display",false);
		//$this->display("Index/reduce");
	}
	public  function set_display(){
		$code = I('code');//前端传来的code值
		if(empty($code)){
			echo"<script>alert('请授权！');history.go(-1);</script>";
			return ;
		}
		$jsoninfo = $this->get_access_token($code);
		$openid = $jsoninfo["openid"];//从返回json结果中读出openid
		session('openid', $openid);
		$sign = $this->GetSignPackage();
		$this->assign('share_wx',$sign);
		$this->display('Index/reduce');
	}
	public function homepage(){
		$sign = $this->GetSignPackage();
		$this->assign('share_wx',$sign);
		$this->display('Index/index');
	}
	public function fileChange(){
		$openid=session('openid');
		if($_FILES['file']['size'] > 10 * 1024 * 1024){
			$this->ajaxReturn(array('errorCode' => 2, 'errorMsg' => '上传失败，图片大小不应超过2MB'), 'json');
		}
		//dump($_FILES);
		if(!$_FILES['file']['tmp_name']){
			$this->ajaxReturn(array('errorCode' => 4, 'errorMsg' => '上传失败'), 'json');
		}
		$last = strstr($_FILES['file']['name'], '.');
		$head = strstr($_FILES['file']['name'], '.', true);
		$title = $openid.md5($head.date('YmdHis')).$last;
		$titleNew = $openid.md5($head.date('YmdHis')).".png";
		session('title',$titleNew);
		$location="./Public/upload/".$title;
		$locationNew="./Public/upload/".$titleNew;
		$new="./Public/upload/";
		$url="../../../".$locationNew;
		move_uploaded_file($_FILES['file']['tmp_name'],$location);
		$this->ToPNG($location, $locationNew);
		$im = imagecreatefrompng($locationNew);
		if ($im && imagefilter($im, IMG_FILTER_GRAYSCALE)) {
			//  echo 'Image converted to grayscale.';
			imagepng($im, $locationNew);
		} else {
			//echo 'Conversion to grayscale failed.';
		}
		imagedestroy($im);
		$im = imagecreatefrompng($location);
		if ($im && imagefilter($im, IMG_FILTER_GRAYSCALE)) {
			// echo 'Image converted to grayscale.';
			imagepng($im, "$location");
		} else {
			// echo 'Conversion to grayscale failed.';
		}
		imagedestroy($im);
		$this->ajaxReturn(array('errorCode' => 0, 'url' =>"url($url)"), 'json');
	}
	public function ToPNG($im,$new){
		$forgin=$im;
		$fnew=$new;
		if (pathinfo($forgin,PATHINFO_EXTENSION) == 'jpg')
		$im = imagecreatefromjpeg($forgin);
		else if (pathinfo($forgin,PATHINFO_EXTENSION) == 'gif')
		$im = imagecreatefromgif($forgin);
		imagepng($im,$fnew);
		imagedestroy($im);
	}
	public function createPoster(){
		$openid=session('openid');
		$contents=array();
		$type=I('type');
		$material=I('material');
		$contents[4]=I('foot');
		$contents[5]=session("title");
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
		//$contents[5]=substr($contents[5],26,-1);
		$table=M('order_list');
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
		$openid=session('openid');
		$time=date('Y-m-d H:i:s');
		$dateTime=strtotime($time);
		$image = base64_decode(substr($image, 22));
		header('Content-Type: image/png');
		$createImage=$openid.$dateTime."2.png";
		session('createImage',$createImage);
		$url="/upload/".$createImage;
		$filename =  "./Public/upload/".$createImage;
		$fp = fopen($filename, 'w');
		fwrite($fp, $image);
		fclose($fp);
		$table=M('order_list');
		$title=session('title');
		$table->where("postImage='$title'")->setField('createImage',$createImage);
		$this->ajaxReturn(array('errorCode' => 0, 'url' =>"$url)",'createImage' => "$createImage"), 'json');
		return "数据库更新了createImg";
	}
	public function showPoster(){
		$openid=session('openid');
		$createImage=session('createImage');
		$sign = $this->GetSignPackage();
		$pieces=session('pieces');
		unset($_SESSION['pieces']);
		$this->assign('share_wx',$sign);
		$this->assign('openid',$createImage);
		//$this->assign('openid',$openid);
		$this->assign('pieces',$pieces);
		$this->display("Index/showPoster");
		return "showPoster";
	}
	public function  imgCut(){
		$this->display("Index/imgCut");
	}
	public  function changeCut(){
		$image=I('image');
		//$image=substr($image,22)."=";
		//dump($image);
		$openid=session('openid');
		$time=date('Y-m-d H:i:s');
		$dateTime=strtotime($time);
		$image = base64_decode(substr($image, 22));
		header('Content-Type: image/png');
		$createImage=$openid.".png";
		$titleNew = $openid.md5($head.date('YmdHis')).".png";
		session("title",$titleNew);
		$url="/upload/".$titleNew;
		$filename =  "./Public/upload/".$titleNew;
		$fp = fopen($filename, 'w');
		fwrite($fp, $image);
		fclose($fp);
		$this->ajaxReturn(array('errorCode' => 0, 'url' =>"$url)"), 'json');
		return "ajaxReturn";
	}
	public function reduce(){
		//phpinfo();
		//dump("sss");
		session("openid",1);
		$this->display("Index/reduce");
		return "reduce";
	}

	public function showSword(){
		phpinfo();
		$this->display("Index/showSword");
		return "showSword";
	}
}



