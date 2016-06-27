<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no"/>
    <title>JavaScript 图片截取效果</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="/activity/Public/js/cutBefore.js"></script>
<script type="text/javascript" src="/activity/Public/js/drag.js"></script>
<script type="text/javascript" src="/activity/Public/js/resize.js"></script>
<script src="/activity/Public/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="/activity/Public/js/html2canvas.js"></script>
<script type="text/javascript" src="/activity/Public/js/imgCut.js"></script>
<link rel="stylesheet" type="text/css" href="/activity/Public/css/imgCut.css">
</head>
<body>
<table width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="300"><div id="bgDiv">
        <div id="dragDiv">
          <div id="rRightDown"> </div>
          <div id="rLeftDown"> </div>
          <div id="rRightUp"> </div>
          <div id="rLeftUp"> </div>
          <div id="rRight"> </div>
          <div id="rLeft"> </div>
          <div id="rUp"> </div>
          <div id="rDown"></div>
        </div>
      </div></td>
    <td align="center"><div id="viewDiv"> </div></td>
  </tr>
</table>
<br />
<input id="idSize" type="button" value="缩小显示" />
<input id="idOpacity" type="button" value="全透明" />
<input id="idColor" type="button" value="白色背景" />
<input id="idMin" type="button" value="设置最小尺寸" />
<input id="idView" type="button" value="缩小预览" />
<input id="idImg" type="button" value="换图片" />
<input id="cutImg" type="button" value="完成剪切" onclick="cutImg();" />
<br /><br />
<input id="idPicUrl" type="hidden" value="/activity/Public/css/images/kme01.jpg" />
<img  src="" id="createImg">
<script type="text/javascript">
var imgSource=$("#idPicUrl").val();
//var imgSource="images/r_mm14.jpg";
var ic = new ImgCropper("bgDiv", "dragDiv", imgSource, {
	Width: 300, Height: 400, Color: "#000",
	Resize: true,
	Scale:true,
	Right: "rRight", Left: "rLeft", Up:	"rUp", Down: "rDown",
	RightDown: "rRightDown", LeftDown: "rLeftDown", RightUp: "rRightUp", LeftUp: "rLeftUp",
	Preview: "viewDiv", viewWidth: 300, viewHeight: 300
})
$no("idSize").onclick = function(){
	if(ic.Height == 200){
		ic.Height = 400;
		this.value = "缩小显示";
	}else{
		ic.Height = 200;
		this.value = "还原显示";
	}
	ic.Init();
}

$no("idOpacity").onclick = function(){
	if(ic.Opacity == 0){
		ic.Opacity = 50;
		this.value = "全透明";
	}else{
		ic.Opacity = 0;
		this.value = "半透明";
	}
	ic.Init();
}

$no("idColor").onclick = function(){
	if(ic.Color == "#000"){
		ic.Color = "#fff";
		this.value = "白色背景";
	}else{
		ic.Color = "#000";
		this.value = "黑色背景";
	}
	ic.Init();
}

$no("idMin").onclick = function(){
	if(ic.Min){
		ic.Min = false;
		this.value = "设置最小尺寸";
	}else{
		ic.Min = true;
		this.value = "取消最小尺寸";
	}
	ic.Init();
}

$no("idView").onclick = function(){
	if(ic.viewWidth == 200){
		ic.viewWidth = 300;
		this.value = "缩小预览";
	}else{
		ic.viewWidth = 200;
		this.value = "扩大预览";
	}
	ic.Init();
}

$no("idImg").onclick = function(){
	if(ic.Url == "images/r_xx2.jpg"){
		ic.Url = "images/r_min.jpg";
	}else{
		ic.Url = "images/r_xx2.jpg";
	}
	ic.Init();
}

</script>
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
</html>