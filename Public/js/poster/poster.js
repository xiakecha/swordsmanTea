//function changeSrc(url){
//	 $.ajax({
//         url: "changeSrc",    //请求的url地址
//         dataType: "json",   //返回格式为json
//         async: true, //请求是否异步，默认为异步，这也是ajax重要特性
//         data: {
//		 image: url,
//		 },    //参数值
//         type: "post",   //请求方式
//         success: function(data) {
//            var reUrl = "http://127.0.0.1/swordsmanTea/index.php/Home/Index/showPoster?image="+data.createImage;
//            $('#reUrl').attr('value',reUrl);
//			 GoShow();
//         	//alert("成功");
//             //请求成功时处理
//			 //$('#back').css('height',$(window).height());
//         },
//         error: function() {
//             //请求出错处理
//        	 alert("处理失败");
//         }
//     });
//}
//window.onload=function(){
//	//grayscale(document.getElementById("back"));
//    // $('#back').css('height',$(window).height());
//    // $('#back').css('width',$(window).width());
//    html2canvas(document.getElementById('page')).then(function(canvas) {
//    	var url=canvas.toDataURL();
//    	$('#createImg').attr('src',url);
//    	$('#page').hide();
//    	changeSrc(url);
//    	//console.log(url)
//    });
//    //changeSrc(url);
//    
//}
//function GoShow(){
//    var redir=$("#reUrl").val();
//    //alert(redir);
//    //window.location.href=redir; 
//}