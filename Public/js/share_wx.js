	var share_wx=$(#"share_wx").val();
wx.config({
			debug: false,
			appId: share_wx["appId"],
			timestamp: share_wx["timestamp"],
			nonceStr: share_wx["nonceStr"],
			signature: share_wx["signature"],
			jsApiList: [
			// 所有要调用的 API 都要加到这个列表中
				"onMenuShareTimeline","onMenuShareAppMessage"
			]
		});
		wx.ready(function(){     
		    	wx.onMenuShareTimeline({  
		            title: '1元抢“码”子', // 分享标题
		            link: "http://activity.evideostb.com/activity/Home/Crowdfunding/", // 分享链接
		            imgUrl: 'http://activity.evideostb.com/activity/Public/css/Image/share_wx01',   // 分享图标
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
			        title: '1元抢“码”子', // 分享标题
			        desc: '视易K20点歌机荣耀登场，淘宝众筹只需1元，就有机会抢鲜嗨唱', // 分享描述
			        link: "http://activity.evideostb.com/activity/Home//Crowdfunding/", // 分享链接
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
