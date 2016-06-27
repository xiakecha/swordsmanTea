var photo = $('#photo');
function isCanvasSupported(){
    var elem = document.createElement('canvas');
    return !!(elem.getContext && elem.getContext('2d'));
}
var g_event = null;
$('#photo').on('change', function(event){
    $("#cutArea").show();
	$("#loading").show();
    $("#bo").hide();
    if(!isCanvasSupported){
    	alert("浏览器不行啊");
        return;
　　}　　　　
    g_event = event;
    compress(g_event, 1, function(base64Img){
    	$('#idPicUrl').attr('value',base64Img);
        $("#loading").hide();
    	startCut();
　　　});
});

$("#needTurn").on('change', function() {
    var state=$("#needTurn").val();
    //alert(state);
    if (g_event) {
        compress(g_event, state, function(base64Img){
        $('#idPicUrl').attr('value',base64Img);
        $("#loading").hide();
        startCut();
　　　});
    }
    
});

function compress(event, status, callback){
    var file = event.currentTarget.files[0];
    var reader = new FileReader();
    reader.onload = function (e) {
        var image = $('<img/>');
        image.on('load', function () {
             var square = 700;
             var canvas = document.createElement('canvas');
             canvas.width = square;
             canvas.height = square;
             var context = canvas.getContext('2d');
             context.clearRect(0, 0, square, square);
             var imageWidth;
             var imageHeight;
             var offsetX = 0;
             var offsetY = 0; 
            if (this.width > this.height) {
                  imageWidth = Math.round(square * this.width / this.height);
                  imageHeight = square;
                 offsetX = - Math.round((imageWidth - square) / 2);
           } else {
                 imageHeight = Math.round(square * this.height / this.width);
                 imageWidth = square; 
                 offsetY = - Math.round((imageHeight - square) / 2); 
           }
            if(status == 2){
                context.translate(0,imageHeight);
                context.rotate(-90*Math.PI/180);
                context.drawImage(this, offsetX, offsetY, imageWidth, imageHeight);
                // ctx.drawImage(img, 0, 0, imageWidth, imageWidth);
                }
            else if(status == 3){
                context.translate(imageHeight,00);
                context.rotate(90*Math.PI/180);         
                context.drawImage(this, offsetX, offsetY, imageWidth, imageHeight);
                }
            else{
                context.drawImage(this, offsetX, offsetY, imageWidth, imageHeight);
                }
            var imgdate=context.getImageData(0,0,imageWidth,imageHeight);
            var data = canvas.toDataURL('image/png');
            callback(data);
         });
 
          image.attr('src', e.target.result);
       };
  
     reader.readAsDataURL(file);
}
function cutImg(){
	 html2canvas(document.getElementById('viewDiv')).then(function(canvas) {
		//$("#viewDiv").show();
       	 var url=canvas.toDataURL();
         var dataUrl="url('"+url+"')"
         $('#photo').css('background-image', dataUrl);   	// $('#page').hide();
   	changeCut(url);
   	// console.log(url)
   });
}  
function changeCut(url){
	 $.ajax({
        url: "changeCut",    // 请求的url地址
        dataType: "json",   // 返回格式为json
        async: true, // 请求是否异步，默认为异步，这也是ajax重要特性
        data: {
		 image: url,
		 },    // 参数值
        type: "post",   // 请求方式
        success: function(data) {
        	 //alert("成功");
             $("#cutArea").hide();
             $("#bo").show();
        },
        error: function() {
            // 请求出错处理
       	 alert("处理失败");
        }
    });
}
function create(){
    var foot=$("#foot").val();
    if(foot.length>10){
        var d = dialog({
            width:250,
            height:50,
            lock:true,
            title: '提示',
            content: '亲，尾行超过字数了，显示不佳，请核实哈。',
            okValue: '确定',
            ok: function () {
            },
        });
        d.showModal();
        return ;
    }
    if(foot.length<1){
        var d = dialog({
            width:250,
            height:50,
            lock:true,
            title: '提示',
            content: '亲，尾行字数太少了，显示不佳，请核实哈。',
            okValue: '确定',
            ok: function () {
            },
        });
        d.showModal();
        return ;
    }
    var photo=$("#photo").val();
    if(photo.length==0){
        var d = dialog({
            width:250,
            height:50,
            lock:true,
            title: '提示',
            content: '亲，记得上传图片啊',
            okValue: '确定',
            ok: function () {
            },
        });
        d.showModal();
        return ;
    }
    $("#createPoster").submit();
}