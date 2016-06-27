<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no"/>
    <title>我就是我</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="/swordsmanTea/Public/css/poster/poster.css" rel="stylesheet" type="text/css">
<script src="/swordsmanTea/Public/js/jquery-1.11.3.min.js"></script>
<script src="/swordsmanTea/Public/js/mobieCut/html2canvas.js"></script>
</head>
<body  id="body" >
<div id="page">
<img class="grayscale"  id="back" alt="无法显示" src="/swordsmanTea/Public/image/index/bg03.png">
<input type="hidden" name="material" value="<?php echo ($material); ?>" id="material">
<img class="userphoto"  id="back" alt="无法显示" src="/swordsmanTea/Public/upload/<?php echo ($con[5]); ?>">
<div class='charater'><div class='shuli'><?php echo ($con[4]); ?></div></div>
<div class='postFile'><div class='typeStyle'><?php echo ($type); ?></div></div>
</div>
<input type="hidden" id="reUrl" value="">
<input type="image" src="" id="createImg" name="createImg">
</body>
<script src="/swordsmanTea/Public/js/poster/poster.js"></script>
</html>