<?php
//接口URL地址：http://120.27.104.19:3002/Hubu/Interface/Android/course_info.php?format=json&course_id=2

/**
 * 向客户端提供指定课程的章节信息
 * 客户端需要通过GET方式提交一个字符串信息用以制定要获取的是哪个课程
 */

require_once 'response.php';    //引入公共文件
require_once 'db.php';          //数据库连接文件
require_once 'common.php';      //引入公共文件

//接收异常，数据库连接失败
try {
    $connect = Db::getInstance()->connect();//mysql连接资源
} catch (Exception $e){
    // $e->getMessage();//获取错误信息，调试模式使用
    return Response::show(403, '数据库链接失败');
}

//获取用户通过GET提交的课程ID
$course_id = isset($_GET['course_id']) ? $_GET['course_id'] : 0;//如果没有给出course_id则默认为0
//echo $course_id;
//当$course_id为数字且不为零
if (is_numeric($course_id) && $course_id > 0){
    $course_info = getCourseSectionChapterList($course_id);
}else {
    //$course_id 字符不合法或者为0
    return Response::show(410,'客户端指定的课程的ID信息不合法或者未指定');
    exit();
}

//判断数据是否存在，存在就返回，不存在就返回不存在状态码
if ($course_info){
    return Response::show(411,'课程章节列表细心获取成功',$course_info);
}else {
    return Response::show(412,'课程章节列表细心获取失败',$course_info);
}