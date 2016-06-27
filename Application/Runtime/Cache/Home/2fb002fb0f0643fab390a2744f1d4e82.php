<?php if (!defined('THINK_PATH')) exit();?>	<!DOCTYPE html>
	<html>
	<head lang="en">
	    <meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width,user-scalable=no"/>
	    <title>我就是我</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link href="/swordsmanTea/Public/css/Beself.css" rel="stylesheet" type="text/css">
	<link href="/swordsmanTea/Public/css/ui-dialog.css" rel="stylesheet" type="text/css"/>
	<script src="/swordsmanTea/Public/js/jquery-1.11.3.min.js"></script>
	<script src="/swordsmanTea/Public/js/dialog-min.js"></script>
	<script src="/swordsmanTea/Public/js/ajaxfileupload.js"></script>
	<script src="/swordsmanTea/Public/js/grayscale.js"></script>
	<script src="/swordsmanTea/Public/js/Beself.js"></script>
	</head>
	<body>
	<div id="bo">
	<form action="createPoster" method="post" id="createPoster"> 
	<!-- <div id="imageC" class="gray">
	<div class="box">1</div> 
	<label for="file">请上传人物图片:</label> <br/>
	<img id="img" alt="错误" src="/swordsmanTea/Public/css/Images02/postImage.jpg">
	<input type="file" accept="image/*" class="hide" id="postFile" name="file" 
	onchange="ajaxFileUpload();"/>
	<input type="hidden" id="imageUrl" name="imageUrl">
	<div id="loading" hidden><span>玩命上传中！</span></div>
	</div> -->
	<div id="contents">
	<div class="box">2</div> 
	<span>请输入人物描述</span><br/>
	<input type="text" id="head" name="head" class="input" value="" placeholder="3-7个汉字哦"/><br/>
	<input type="text" id="con1" name="con1" class="input" value="一直" placeholder="2至4汉字哦" /><br/>
	<input type="text" id="con2" name="con2" class="input" value="一直" placeholder="2至4汉字哦"/><br/>
	<input type="text" id="con3" name="con3" class="input" value="一直" placeholder="2至4汉字哦"/><br/>
	<span class="then">那又怎样</span>
	<span class="then">我就是我</span>
	<input type="text" id="foot" placeholder="1-10个汉字哦"class="input" name="foot"/>
	</div>
	<br/>
	<input type="button" id="button04" name="button_submit" onclick="create();" value="生成海报">
	</form>
	</div>
	<div id="cut" hidden>
		<img id="bwImage"src="">
	</div>
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
			            title: '我就是我', // 分享标题  
			            link: "http://activity.evideostb.com/activity/Home/Beself/", // 分享链接  
			            imgUrl: 'http://activity.evideostb.com/activity/Public/css/Image/share_wx01.png',   // 分享图标  
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
				        desc: '视易K20点歌机荣耀登场，淘宝众筹只需1元，就有机会抢鲜嗨唱', // 分享描述  
				        link: "http://activity.evideostb.com/activity/Home//Beself/", // 分享链接  
				        imgUrl: 'http://activity.evideostb.com/activity/Public/css/Image/share_wx01.png',  // 分享图标  
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