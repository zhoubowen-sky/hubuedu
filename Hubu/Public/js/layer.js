﻿if($('.layui-layer'.length==0)){
    $('#login-div-1').hide();
    $('#login-div-2').hide();
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
$('#m-nav-other').on('click',function () {
   $('#m-nav-first').removeClass('btn btn-warning').addClass('btn btn-link');
   $('#m-nav-other').removeClass('btn btn-link').addClass('btn btn-warning');
});
$('#m-nav-first').on('click',function () {
    $('#m-nav-first').removeClass('btn btn-link').addClass('btn btn-warning');
});


    
