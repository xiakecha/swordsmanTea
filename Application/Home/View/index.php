<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<title>index</title>

<?php
			
	date_default_timezone_set("Asia/Hong_Kong");
	$nowTime = date("Y-m-d H:i:s");	
	$beginTime = "2015-08-21 00:00:00";
	$endTime  =  "2015-08-31 00:00:00";

	if(strtotime($nowTime)<strtotime($beginTime) || strtotime($nowTime)>strtotime($endTime)){
		//活动还未开始或活动已过期
		header("Location:"."http://112.74.86.188/km_data_center/kmi/Application/Home/View/end.php");
		exit;
	}else if(strtotime($nowTime)<strtotime($endTime) && strtotime($nowTime)>strtotime($beginTime)){
		
		//获取网页的code之后，就可以获取openid
		$APPID='wx01881e098d8c9878';
		$REDIRECT_URI='http://ktvhome.evideostb.com/lottery/snsapi_base/';
		$scope='snsapi_base';

		$url  = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$APPID.'&redirect_uri='.urlencode($REDIRECT_URI).'&response_type=code&scope='.$scope.'&state='.$state.'#wechat_redirect';
    	header("Location:".$url);
    	exit;
	}
?>

</head>
<body >

</body>
</html>