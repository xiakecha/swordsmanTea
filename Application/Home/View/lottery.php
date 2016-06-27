<!--抽奖结果页面-->

<script type="text/javascript">
	
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<title>lottery</title>
</head>

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
wx.config({
	debug: true,
	appId: '<?php echo $signPackage["appId"]; ?>',
	timestamp: <?php echo $signPackage["timestamp"]; ?>,
	nonceStr: '<?php echo $signPackage["nonceStr"]; ?>',
	signature: '<?php echo $signPackage["signature"]; ?>',
	jsApiList: [
	// 所有要调用的 API 都要加到这个列表中
		"onMenuShareTimeline",
		"onMenuShareAppMessage"
	]
});

wx.ready(function () {  
	
    document.getElementById("button1").onclick = function(){
    	wx.onMenuShareTimeline({  
            title: '星网视易', // 分享标题  
            link: pageUrl, // 分享链接  
            imgUrl: 'http://escloud-media.oss-cn-hangzhou.aliyuncs.com/escloud/newsmsg-small.png', // 分享图标  
            success: function () {  
                // 用户确认分享后执行的回调函数  
	        },  
	        cancel: function () {  
	            // 用户取消分享后执行的回调函数  
	        },  
	        fail: function (res) { 
	            alert("分享失败，请重新尝试");  
            }  
        }); 
    }
    document.getElementById("button2").onclick = function(){
    	wx.onMenuShareAppMessage({  
	        title: '星网视易', // 分享标题  
	        desc: '星网视易', // 分享描述  
	        link: pageUrl, // 分享链接  
	        imgUrl: 'http://escloud-media.oss-cn-hangzhou.aliyuncs.com/escloud/newsmsg-small.png', // 分享图标  
	        type: 'link', // 分享类型,music、video或link，不填默认为link  
	        dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空  
	        success: function () {  
	            // 用户确认分享后执行的回调函数  
	        },  
	        cancel: function () {  
	            // 用户取消分享后执行的回调函数  
	        }  
    	}
   });  
});  
</script>
<body>

	<div align='center'>
		中奖码：<?php echo $code; ?>
	<br/><br/>
	</div>
	<div align="center">
		<input type="submit" name="button" id="button1" value=" 分享到朋友圈 " />
		<br/>
		<input type="submit" name="button" id="button2" value="分享给好友" />
	</div>
	<br/><br/><br/><br/><br/>
	<div align='center'>
	文字文字文字文字文字文字文字文字文字文字
	</div>
	<div align='center'>
		<?php 
			echo "<input type=\"button\" onclick=\"window.location.href=\'http://112.74.86.188/km_data_center/kmi/Application/Home/View/first_code.php?openid=".$openid."&access_token=".$access_token."&code=".$code."\'\" value=\"我的中奖码\" ></input>";
		?>
		<button id="button2" >分享给好友</button>
</div>
</body>
</html>