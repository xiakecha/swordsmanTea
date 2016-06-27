<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no"/>
    <title>我就是我</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="/swordsmanTea/Public/js/jquery-1.11.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="/swordsmanTea/Public/css/index/index.css" >
</head>
<body>
<div id="margin">
  <div id="padding">
<img alt="" id="img" src="">
</div>
</div>
<div class="button">
  <a href="http://localhost/swordsmanTea/index.php/Home/Index/reduce">制作我的专属侠客茶</a>
</div>
<div class="button submitTo">
  <a href="http://localhost/swordsmanTea/index.php/Home/Index/reduce">不够个性，提交后台</a>
</div>
</body>
<script>
var url = location.search; //获取url中"?"符后的字串
if (url.indexOf("?") != -1) {    //判断是否有参数
   var str = url.substr(1); //从第一个字符开始 因为第0个是?号 获取所有除问号的所有符串
   strs = str.split("=");   //用等号进行分隔 （因为知道只有一个参数 所以直接用等号进分隔 如果有多个参数 要用&号分隔 再用等号进行分隔）
   strs[1]=strs[1].split("&");
   //直接弹出第一个参数 （如果有多个参数 还要进行循环的）
   url="/swordsmanTea/Public/upload/"+strs[1][0];
   $('#img').attr('src',url);
   window.onload=function(){
    var width=$(window).width()/4.5;
    var height=$(window).height()/11;
     $('#img').css('height',$(window).height()-2*height);
     $('#img').css('width',($(window).height()-2*height)/2);
    var buttonH=$(window).height()/568*46;
   }
   
}
function goShow(){
  window.location.href="http://192.168.56.1/swordsmanTea/index.php/Home/Index/Beself/";
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
                title: "<?php echo ($pieces); ?>", // 分享标题  
               // desc: "", // 分享描述  
                link: "http://101.201.111.74/index.php/Home/Index/showPoster?image=<?php echo ($openid); ?>", // 分享链接  
                imgUrl: "http://101.201.111.74/swordTea/Public/upload/<?php echo ($openid); ?>",   // 分享图标  
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
              desc: "<?php echo ($pieces); ?>", // 分享描述  
              link: "http://101.201.111.74/index.php/Home/Index/showPoster?image=<?php echo ($openid); ?>", // 分享链接  
              imgUrl: "http://101.201.111.74/swordTea/Public/upload/<?php echo ($openid); ?>",  // 分享图标  
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