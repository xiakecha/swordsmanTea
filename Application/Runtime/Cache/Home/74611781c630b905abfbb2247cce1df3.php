<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no"/>
    <title>我就是我</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="/activity/Public/css/poster.css" rel="stylesheet" type="text/css">
<script src="/activity/Public/js/jquery-1.11.3.min.js"></script>
<script src="/activity/Public/js/html2canvas.js"></script>
<script src="/activity/Public/js/grayscale.js"></script>
<script src="/activity/Public/js/ajaxfileupload.js"></script>
<script src="/activity/Public/js/poster.js"></script>
</head>
<body  id="body" >
<div id="page">
<img class="grayscale"  id="back" alt="无法显示" src="/activity/Public/upload/<?php echo ($con[5]); ?>">
<img src="/activity/Public/css/Images02/logo.png" id="logo">
<div id="contents">
<img src="/activity/Public/css/Images02/url.jpg" id="url">
<span><?php echo ($con[0]); ?></span><br/>
<div id="contendBody">
<span><?php echo ($con[1]); ?></span><br/>
<span><?php echo ($con[2]); ?></span><br/>
<span><?php echo ($con[3]); ?></span><br/>
</div>
<span id="so">那又怎样</span><br/>
<div id="contendFoot">
<span id="then">我就是我</span><br/>
<span><?php echo ($con[4]); ?></span>
</div>
</div>
</div>
<input type="hidden" id="reUrl" value="http://127.0.0.1/activity/index.php/Home/Beself/showPoster?image=<?php echo ($openid); ?>.png">
<input type="image" src="" id="createImg" name="createImg">
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript">
		wx.config({
			debug: false,
			appId: "<?php echo ($share_wx["appId"]); ?>",
			timestamp: <?php echo ($share_wx["timestamp"]); ?>,
			nonceStr: "<?php echo ($share_wx["nonceStr"]); ?>",
			signature: "<?php echo ($share_wx["signature"]); ?>",
			jsApiList: [
			// 所有要调用的 API 都要加到这个列表中
				"onMenuShareTimeline","onMenuShareAppMessage"
			]
		});
		wx.ready(function(){     
		    	wx.onMenuShareTimeline({  
		            title: "<?php echo ($con[4]); ?>", // 分享标题  
		           // desc: "", // 分享描述  
		            link: "http://activity.evideostb.com/activity/Home/Beself/showPoster?image=<?php echo ($openid); ?>.png", // 分享链接  
		            imgUrl: "http://activity.evideostb.com/activity/Public/upload/<?php echo ($openid); ?>.png",   // 分享图标  
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
		    	wx.onMenuShareAppMessage({  
			        title: '我就是我', // 分享标题  
			        desc: "<?php echo ($con[4]); ?>", // 分享描述  
			        link: "http://activity.evideostb.com/activity/Home//Beself/showPoster?image=<?php echo ($openid); ?>.png", // 分享链接  
			        imgUrl: "http://activity.evideostb.com/activity/Public/upload/<?php echo ($openid); ?>.png",  // 分享图标  
			        type: 'link', // 分享类型,music、video或link，不填默认为link  
			        dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空  
			        success: function () {  
			            // 用户确认分享后执行的回调函数  
			        },  
			        cancel: function () {  
			            // 用户取消分享后执行的回调函数  
			        }  
		    	});
		});  
	</script>
</body>
</html>