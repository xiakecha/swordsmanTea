<?php
namespace Home\Controller;

$openid = $_GET['openid'];
$access_token = $_GET['access_token'];
	$APPID='wx01881e098d8c9878';
	$REDIRECT_URI='http://ktvhome.evideostb.com/lottery/snsapi_userinfo/';
	$scope='snsapi_userinfo';    
	$url  = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$APPID.'&redirect_uri='.urlencode($REDIRECT_URI).'&response_type=code&scope='.$scope.'&state='.$state.'#wechat_redirect';
	header("Location:".$url);
	exit;