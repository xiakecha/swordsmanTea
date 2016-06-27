window.onload=function(){
	var material = $("#material");
	$("#back").attr("src","/swordsmanTea/Public/image/index/bg02.jpg");
    html2canvas(document.getElementById('page')).then(function(canvas) {
    	var url=canvas.toDataURL();
    	$('#createImg').attr('src',url);
    	$('#page').hide();
    	changeSrc(url);
    	//console.log(url)
    });
    //changeSrc(url);
    
}
function changeSrc(url){
	 $.ajax({
        url: "changeSrc",    //请求的url地址
        dataType: "json",   //返回格式为json
        async: true, //请求是否异步，默认为异步，这也是ajax重要特性
        data: {
		 image: url,
		 },    //参数值
        type: "post",   //请求方式
        success: function(data) {
	     //var reUrl = "http://101.201.111.74/index.php/Home/Index/showPoster?image="+data.createImage;
           var reUrl = "http://localhost/swordsmanTea/index.php/Home/Index/showPoster?image="+data.createImage;
           $('#reUrl').attr('value',reUrl);
			 GoShow();
        },
        error: function() {
            //请求出错处理
       	 alert("处理失败");
        }
    });
}
function GoShow(){
    var redir=$("#reUrl").val();
    //alert(redir);
    window.location.href=redir; 
}