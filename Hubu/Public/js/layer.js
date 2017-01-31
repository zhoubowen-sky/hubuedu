if($('.layui-layer'.length==0)){
    $('#login-div-1').hide();
    $('#login-div-2').hide();
	$(".login-1 #user").each(function(){
        var maxwidth=6;
        if($(this).text().length>maxwidth){ $(this).text($(this).text().substring(0,maxwidth)); $(this).html($(this).html()+'…');
        }
    });
}
 $('#login').on('click', function() {
     layer.open({
         type: 1,
         title: ['登录', 'font-size:18px;background: #1e6f46;color: white;padding-left:185px;'],
         area: ['420px', '305px'],
         shadeClose: true, //点击遮罩关闭
         end:function () {
             $('#login-div-1').hide();
         },
         content: $('#login-div-1')
     });
     

 });
 $('#login2').on('click', function(){
        layer.open({
            type: 1,
            title: ['注册', 'font-size:18px;background: #1e6f46;color: white;padding-left:185px;'],
            area: ['420px', '360px'],
            shadeClose: true, //点击遮罩关闭
            end:function () {
                $('#login-div-2').hide();
            },
            content: $('#login-div-2')
        });
});
$('a#m-nav-other').click(function () {
     $(this).removeClass().addClass("btn btn-warning").siblings().removeClass().addClass('btn btn-link');
});

function iFrameHeight() {   
	var ifm= document.getElementById("iframepage");   
	var subWeb = document.frames ? document.frames["iframepage"].document : ifm.contentDocument;   
	if(ifm != null && subWeb != null) {
		ifm.height = subWeb.body.scrollHeight;
		ifm.width = subWeb.body.scrollWidth;
	}   
}



    
