<?php
//ThinkPHP框架入口
//设置head头，防止乱码
header("Content-type:text/html,charset=utf-8");

/**
 * 功能：制作一个输出调试函数，便于开发的时候使用
 * @param 需要输出的对象或者其他信息  $msg
*/
function show_bug($msg){
    echo "<pre style = 'color:blue'";
    var_dump($msg);
    echo "</pre>";
}

//把当前的模式设置为debug模式，项目上线后需改为生产模式  define(“APP_DEBUG”,false);
define("APP_DEBUG", true);

//自己定义的CSS JS IMG路径全局常量，用以存储网页相关的资源文件的路径
//定义路径常量，直接定义http绝对路径，框架在应用的时候会自动将SITE_URL 与 CSS等资源路径进行组合得到一个统一资源定位符
define("SITE_URL", "http://web.hubu.edu:3002/");//站点路径
define("ADMIN_ROOT_URL", SITE_URL."Hubu/Public/");//资源根路径
define("ADMIN_CSS_URL", SITE_URL."Hubu/Public/css/");//css路径
define("ADMIN_JS_URL", SITE_URL."Hubu/Public/js/");//js路径
define("ADMIN_IMG_URL", SITE_URL."Hubu/Public/images/");//images图片路径
define("ADMIN_IE_URL", SITE_URL."Hubu/Public/ie/");//适配ie9以下浏览器的js文件
//为上传用户头像路径设置路径
define("ADMIN_IMG_UPLOADS", SITE_URL."Hubu/Public/");
//定义用户头像默认存储位置
define("ADMIN_DEFAULT_IMG", "Uploads/default/default_admin_user.jpg");

//1.定义我们的项目名称
define("APP_NAME","hubu");

//2.定义当前项目的路径
define("APP_PATH","./Hubu/");

//3.引入框架的核心程序
include "./ThinkPHP/ThinkPHP.php";

