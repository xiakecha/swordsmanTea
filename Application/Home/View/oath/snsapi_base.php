<?php

	$code = $_GET['code'];//前端传来的code值
	$appid = "wx01881e098d8c9878";
	$appsecret = "d4d937a8a4ffa6370988384a2a9a77a2";//获取openid
	$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
	$result = https_request($url);
	$jsoninfo = json_decode($result, true);
	$openid = $jsoninfo["openid"];//从返回json结果中读出openid
	$access_token = $jsoninfo["access_token"];//从返回json结果中读出openid
//	
	header("Location:"."http://112.74.86.188/km_data_center/kmi/Application/Home/View/start.php?openid=$openid&access_token=$access_token");
	exit;
	echo "code=".$code;
	echo "<br/>";
	echo "openid=".$openid;
	
	function https_request($url,$data = null){
	
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
?>

