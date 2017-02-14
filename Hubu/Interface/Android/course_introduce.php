<?php
//接口URL地址：http://120.27.104.19:3002/Hubu/Interface/Android/course_introduce.php?format=json&course_id=1&student_id=9

/**
 * 向客户端提供指定课程的介绍信息
 * 客户端需要通过GET方式提交一个字符串信息用以制定要获取的是哪个课程
 * 同时客户端提交一个字符串，用户的ID信息，用以表明是哪位用户
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
$course_id  = isset($_GET['course_id']) ? $_GET['course_id'] : 0;//如果没有给出course_id则默认为0
$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : 0;//如果没有给出student_id则默认为0
//echo $course_id;
//当$course_id为数字且不为零
if (is_numeric($course_id) && $course_id > 0){
    //当$student_id为数字且不为零
    if (is_numeric($student_id) && $student_id > 0){
        //课程ID与学生ID都指定正确，输出课程信息以及该学生的该课程的学习进度等信息
        $sql2    = 'select * from hubu_course_name where course_name_id = '.$course_id;//查询出课程的信息的SQL语句
        $result2 = mysql_query($sql2, $connect);//结果集1
        $course_tmp2 = array();//存储课程介绍信息
        //循环取出结果集中的数据
        while($tmp2 = mysql_fetch_assoc($result2)) {
            //var_dump($course_class);
            $course_tmp2[] = $tmp2;
        }
        //var_dump($course_tmp2);
        foreach ($course_tmp2 as $k => &$v){
            $v['course_name_pic'] = ADMIN_IMG_UPLOADS.$v['course_name_pic'];
        }
        $course_introduce = array();
        $course_introduce['course_introduce'] = $course_tmp2;
        
        //学生的学习进度等信息
        
        
        
        
        
        
        
        
        
        
        
        
        $course_introduce['my_study_progress'] = array('test' => '处于测试阶段，学习进度模块还没有做');
        
        return Response::show(424,'课程介绍信息获取成功，学生该课程学习进度获取成功',$course_introduce);
        exit();
        
        
    }elseif (is_numeric($student_id) && $student_id == 0){
        //课程ID指定，学生ID未指定，只输出课程的信息
        $sql1    = 'select * from hubu_course_name where course_name_id = '.$course_id;//查询出课程的信息的SQL语句
        $result1 = mysql_query($sql1, $connect);//结果集1
        $course_tmp1 = array();//存储课程介绍信息
        //循环取出结果集中的数据
        while($tmp1 = mysql_fetch_assoc($result1)) {
            //var_dump($course_class);
            $course_tmp1[] = $tmp1;
        }
        //var_dump($course_tmp);
        foreach ($course_tmp1 as $k => &$v){
            $v['course_name_pic'] = ADMIN_IMG_UPLOADS.$v['course_name_pic'];
        }
        $course_introduce = array();
        $course_introduce['course_introduce'] = $course_tmp1;
        //$course_introduce['my_study_progress'] = array();
        
        return Response::show(423,'课程介绍信息获取成功，未提供学生ID因而不反馈学生的学习进度等信息',$course_introduce);
        exit();
        
    }elseif (!is_numeric($student_id)){
        return Response::show(422,'客户端指定的学生用户的ID信息不合法，不是int类型');
        exit();
    }
}else {
    //$course_id 字符不合法或者为0
    return Response::show(410,'客户端指定的课程的ID信息不合法或者未指定');
    exit();
}

//判断数据是否存在，存在就返回，不存在就返回不存在状态码
/* if ($course_introduce){
    return Response::show(411,'课程章节列表细心获取成功',$course_introduce);
}else {
    return Response::show(412,'课程章节列表细心获取失败',$course_introduce);
} */