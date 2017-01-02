$(document).ready(function(){
  $('#login-div-1').css("display", "block");
});
 $('#login').on('click', function(){
        layer.open({
            type: 2,
            title: ['登录', 'font-size:18px;background: #1e6f46;color: white;padding-left:160px;'],
            area: ['400px', '300px'],
            shadeClose: true, //点击遮罩关闭
			content: '$("#login-div-1")'
        });
    });