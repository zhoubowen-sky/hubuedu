<?php
//接口URL地址：http://120.27.104.19:3002/Hubu/Interface/Android/course_name_list.php?format=json&course_class_code=2

/**
 * 向客户端提供某一特定类别下面所有课程的信息
 * 客户端需要通过GET方式提交一个字符串信息用以制定要获取的是哪个大类的课程
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

//获取用户通过GET提交的课程类别标志码
$course_class_code = isset($_GET['course_class_code']) ? $_GET['course_class_code'] : 0;//如果没有给出course_class_code则默认为0
//echo $course_class_code;
//当$course_class_code为20的时候，选取出所有的课程
if ($course_class_code == 20){
    $sql = 'select * from hubu_course_name';
}elseif ($course_class_code >= 1 && $course_class_code <=13){
    $sql = 'select * from hubu_course_name where course_name_class = '.$course_class_code;
}else {
    //$course_class_code 字符不合法或者为0
    return Response::show(407,'客户端未指定所要获取的课程大类信息或者指定的变量不合法');
    exit();
}

$course_name_list_tmp = array();         //用以存储某一大类课程名称信息的临时数组
$course_name_list     = array();         //用以存储某一大类课程名称信息的数组
$result = mysql_query($sql, $connect);//结果集

//循环取出结果集中的数据
while($course_name = mysql_fetch_assoc($result)) {
    //var_dump($course_name);
    $course_name_list_tmp[] = $course_name;
}
//var_dump($course_name_list_tmp);
//用foreach来遍历数据，将数据转换为所需的格式
foreach ($course_name_list_tmp as $k => $v){
    
     $course_name_list[$k]['course_id']     = $v['course_name_id'];
     $course_name_list[$k]['name']          = $v['course_name_name'];
     $course_name_list[$k]['image']         = ADMIN_IMG_UPLOADS.$v['course_name_pic'];
     $course_name_list[$k]['description']   = $v['course_name_intro'];
     $course_name_list[$k]['teacher']       = $v['course_name_adder'];
     $course_name_list[$k]['choose_count']  = getChoosedCount($v['course_name_id']);//common里面获取选课人数的方法
     $course_name_list[$k]['class']         = getChapterCount($v['course_name_id']);//common里面获取小节总数的方法
}

//var_dump($course_name_list);

//判断数据是否存在，存在就返回，不存在就返回不存在状态码
if ($course_name_list){
    return Response::show(405,'课程名称数据获取成功',$course_name_list);
}else {
    return Response::show(406,'课程名称数据获取失败',$course_name_list);
}