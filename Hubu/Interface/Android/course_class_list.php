<?php
// 接口URL地址：http://120.27.104.19:3002/Hubu/Interface/Android/course_class_list.php?format=json

/**
 * 本接口是用来向客户端提供课程大类信息的数据
 */
require_once 'response.php'; // 引入公共文件
require_once 'db.php'; // 数据库连接文件
                       
// 接收异常，数据库连接失败
try {
    $connect = Db::getInstance()->connect(); // mysql连接资源
} catch (Exception $e) {
    // $e->getMessage();//获取错误信息，调试模式使用
    return Response::show(403, '数据库链接失败');
}

$sql = 'select * from hubu_course_class';

$course_class_list_tmp = array(); // 用以存储课程类别信息的临时数组
$course_class_list = array(); // 用以存储课程类别信息的数组
$result = mysql_query($sql, $connect); // 结果集
                                       
// 循环取出结果集中的数据
while ($course_class = mysql_fetch_assoc($result)) {
    // var_dump($course_class);
    $course_class_list_tmp[] = $course_class;
}

// 用foreach来遍历数据，将数据转换为所需的格式
foreach ($course_class_list_tmp as $k => $v) {
    $course_class_list[$k]['college_id'] = $v['course_class_id'];
    $course_class_list[$k]['name'] = $v['course_class_name'];
    $course_class_list[$k]['type'] = $v['course_class_type'];
}

// var_dump($course_class_list_tmp);

// 判断数据是否存在，存在就返回，不存在就返回不存在状态码
if ($course_class_list) {
    return Response::show(400, '课程类别数据获取成功', $course_class_list);
} else {
    return Response::show(401, '课程类别数据获取失败', $course_class_list);
}