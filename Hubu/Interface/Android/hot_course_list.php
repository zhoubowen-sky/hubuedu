<?php
// 接口URL地址：http://120.27.104.19:3002/Hubu/Interface/Android/hot_course_list.php?format=json

/**
 * 本接口是用来向客户端提供热门课程信息的数据
 */
require_once 'response.php'; // 引入公共文件
require_once 'db.php'; // 数据库连接文件
require_once 'common.php'; // 引入公共函数文件
                           
// 接收异常，数据库连接失败
try {
    $connect = Db::getInstance()->connect(); // mysql连接资源
} catch (Exception $e) {
    // $e->getMessage();//获取错误信息，调试模式使用
    return Response::show(403, '数据库链接失败');
}

$sql = 'select * from hubu_hot_course';

$hot_course_list_tmp = array(); // 用以存储热门课程信息的临时数组
$hot_course_list = array(); // 用以存储热门课程信息的数组
$hot_course_list_final = array(); // 存储热门课程信息的最终数组
$result = mysql_query($sql, $connect); // 结果集
                                       
// 循环取出结果集中的数据
while ($hot_course_code = mysql_fetch_assoc($result)) {
    // var_dump($course_class);
    $hot_course_list_tmp[] = $hot_course_code['hot_course_course_name']; // 只存储ID
}

// 用foreach来遍历数据，将数据转换为所需的格式
foreach ($hot_course_list_tmp as $k => $v) {
    $hot_course_list[] = getHotCourse($v); // 调用common里面的函数来查询出该课程的信息
}

// var_dump($hot_course_list_tmp);
// var_dump($hot_course_list);

foreach ($hot_course_list as $k => $v) {
    $hot_course_list_final[$k]['course_id'] = $v['course_name_id'];
    $hot_course_list_final[$k]['name'] = $v['course_name_name'];
    $hot_course_list_final[$k]['image'] = ADMIN_IMG_UPLOADS . $v['course_name_pic'];
    $hot_course_list_final[$k]['description'] = $v['course_name_intro'];
    $hot_course_list_final[$k]['teacher'] = $v['course_name_adder'];
    $hot_course_list_final[$k]['choose_count'] = getChoosedCount($v['course_name_id']);
    $hot_course_list_final[$k]['class'] = getChapterCount($v['course_name_id']);
}

// 判断数据是否存在，存在就返回，不存在就返回不存在状态码
if ($hot_course_list_final) {
    return Response::show(408, '热门课程信息获取成功', $hot_course_list_final);
} else {
    return Response::show(409, '热门课程信息获取失败', $hot_course_list_final);
}