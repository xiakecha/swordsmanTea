<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,user-scalable=no" />
<script type="text/javascript" src="/swordsmanTea/Public/js/cutBefore.js"></script>
<script type="text/javascript" src="/swordsmanTea/Public/js/drag.js"></script>
<script type="text/javascript" src="/swordsmanTea/Public/js/resize.js"></script>
<script type="text/javascript" src="/swordsmanTea/Public/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="/swordsmanTea/Public/js/dialog-min.js"></script>
<script type="text/javascript" src="/swordsmanTea/Public/js/html2canvas.js"></script>
<link rel="stylesheet" type="text/css" href="/swordsmanTea/Public/css/imgCut.css">
<link rel="stylesheet" type="text/css" href="/swordsmanTea/Public/css/reduce.css">
<link href="/swordsmanTea/Public/css/Beself.css" rel="stylesheet" type="text/css">
  <link href="/swordsmanTea/Public/css/ui-dialog.css" rel="stylesheet" type="text/css"/>
<title>图片压缩上传</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<div id="photosUp">
<p id="header"><div class="box">1</div>请上传您的背景照片</p>
<div class="free-upload-photo" ><span id="photo_img"></span> 
<input type="file" id="photo" class="postFile"/>
<span>图片旋转</span>
<select id="needTurn">
  <option value ="1">无</option>
  <option value ="2">向左</option>
  <option value ="3">向右</option>
</select>
</div>
<img alt="" id="createImg" src="">
<p id="photo_loading" hidden>正在上传...</p>
</br>
<center>
<div id="cutArea" hidden>
<table width="320" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="300">
      <div id="bgDiv">
        

      </div>
    </td>
  </tr>
</table>
<br />
<input id="cutImg" type="button" class="button" value="完成剪切" onclick="cutImg();" />
<br/>
<div id="viewDiv"> </div><br />
<input id="idPicUrl" type="hidden" value="" />
<img src="" hidden id="createImg">
<img src="" id="can_img" alt="" style="height:0">
</div>
</center>
<script type="text/javascript">

function startCut(rotate_img){
	//var imgSource="images/r_mm14.jpg";
  var imgSource=$("#idPicUrl").val();

  Preview(imgSource);

}

function Preview(imgSource) {

  var html = '<div id="dragDiv">\
            <div id="rRightDown"> </div>\
            <div id="rLeftDown"> </div>\
            <div id="rRightUp"> </div>\
            <div id="rLeftUp"> </div>\
            <div id="rRight"> </div>\
            <div id="rLeft"> </div>\
            <div id="rUp"> </div>\
            <div id="rDown"></div>\
          </div>';
    $("#bgDiv").html('').append(html);      

    var ic = new ImgCropper("bgDiv", "dragDiv", imgSource, {
      Width: 300, Height: 400, Color: "#000",
      Resize: true,
      Scale:true,
      Right: "rRight", Left: "rLeft", Up: "rUp", Down: "rDown",
      RightDown: "rRightDown", LeftDown: "rLeftDown", RightUp: "rRightUp", LeftUp: "rLeftUp",
      Preview: "viewDiv", viewWidth: 300, viewHeight: 400
    });
}

</script>
</div>
<div id="bo" >
  <form action="createPoster" method="post" id="createPoster"> 
  <div id="contents">
  <div class="box">2</div> 
  <span>请输入人物描述</span><br/>
  <input type="text" id="head" name="head" class="input" value="" placeholder="3-7个汉字哦"/><br/>
  <div>
 <box class="always"> 一直</box>
 <input type="text" id="con1" name="con1" class="inputFond" value="" placeholder="1-4汉字哦" /><br/>
 <span class="always"> 一直</span>
 <input type="text" id="con2" name="con2" class="inputFond" value="" placeholder="1-4汉字哦"/><br/>
  <span class="always"> 一直</span>
  <input type="text" id="con3" name="con3" class="inputFond" value="" placeholder="1-4汉字哦"/><br/>
  </div>
  <span class="then">那又怎样</span>
  <span class="then">我就是我</span>
  <input type="text" id="foot" placeholder="1-10个汉字哦"class="input" name="foot"/>
  </div>
  <br/>
  <div class="buttonA">
   <a href="JavaScript:create();">生成海报</a>
   </div>
  <!-- <input type="button" id="button04" class="buttonA"name="button_submit" onclick="create();" value="生成海报"> -->
  </form>
  </div>
  <div id="cut" hidden>
    <img id="bwImage"src="">
  </div>
</body>
</html>
<script src="/swordsmanTea/Public/js/beself/reduce.js"></script>