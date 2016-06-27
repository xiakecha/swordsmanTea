<!--开始抽奖页面-->
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<title>start</title>
</head>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
wx.config({
	debug: true,
	appId: '<?php echo $signPackage["appId"];?>',
	timestamp: <?php echo $signPackage["timestamp"];?>,
	nonceStr: '<?php echo $signPackage["nonceStr"];?>',
	signature: '<?php echo $signPackage["signature"];?>',
	jsApiList: [
	// 所有要调用的 API 都要加到这个列表中
		"onMenuShareTimeline",
		"onMenuShareAppMessage"
	]
});

wx.ready(function () {  
	
    document.getElementById("button2").onclick = function(){
    	wx.onMenuShareAppMessage({  
	        title: '星网视易', // 分享标题  
	        desc: '星网视易', // 分享描述  
	        link: 'http://www.baidu.com', // 分享链接  
	        imgUrl: 'http://escloud-media.oss-cn-hangzhou.aliyuncs.com/escloud/newsmsg-small.png', // 分享图标  
	        type: 'link', // 分享类型,music、video或link，不填默认为link  
	        dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空  
	        success: function () {  
	            // 用户确认分享后执行的回调函数  
	            alert("分享成功！");
	        },  
	        cancel: function () {  
	            // 用户取消分享后执行的回调函数  
	        	alert("分享失败！");
	        }  
    	}
   });  
});  
</script>
<body>

<?php 
	
	require_once "jssdk.php";
	$jssdk = new JSSDK("wx01881e098d8c9878", "d4d937a8a4ffa6370988384a2a9a77a2");
	$signPackage = $jssdk->GetSignPackage();

	$openid = $_GET['openid'];
	$access_token = $_GET['access_token'];
	
?>
<div>
	<table align='center'>
		<tr>
			<td>
				<div align="center"><img src="img/1.png" /></div>
			</td>
		</tr>
		<tr>
			<td align='center'><p>K米点歌机——K10</p></td>
		</tr>
		<tr>
			<td><p align="center" style='font:bold'>为家庭K歌量身定制<br/>让客厅一秒变KTV</p></td>
		</tr>
		<tr>
			<td align='center'>
				<?php 		
					echo "<input type=\"button\" onclick=\"window.location.href='http://112.74.86.188/km_data_center/kmi/Application/Home/Controller/isFollower.php?openid=".$openid."&access_token=".$access_token."'\" value=\"免费抽\" ></input>";
				?>
				
			</td>
		</tr>		
	</table>
</div>
<hr>
<p align='center'>文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字文字</p>
<hr>
<p align='center'>文字文字文字文字文字文字文字文字文字文字文字文字文字</p>
<div align='center'>
<?php 
	$code = 'nu';
//	echo "<input type=\"button\" onclick=\"window.location.href='http://112.74.86.188/km_data_center/kmi/Application/Home/Controller/isFollower.php?openid=".$openid."&access_token=".$access_token."'\" value=\"免费抽\" ></input>";
	echo "<input type=\"button\" onclick=\"window.location.href='http://112.74.86.188/km_data_center/kmi/Application/Home/View/first_code.php?openid=".$openid."&access_token=".$access_token."&code=".$code."'\" value=\"我的中奖码\" ></input>" ;
?>
<button id="button2" >分享给好友</button>
</div>

</body>
</html>