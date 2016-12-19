<?php
//ThinkPHP框架入口

//设置head头，防止乱码
header("content-type:text/html,charset=utf-8");

//开启调试模式
define("APP_DEBUG",true);

//1.定义我们的项目名称
define("APP_NAME","teacher");

//2.定义当前项目的路径
define("APP_PATH","./Teacher/");

//3.导入入口文件
require("./ThinkPHP/ThinkPHP.php");
