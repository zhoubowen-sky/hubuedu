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
        $result2 = mysql_query($sql2, $connect);//结果集2
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
        
        //学生的学习进度等信息，首先判断用户是否登录，如果已经登录，再判断用户是否选了这门课
        //不判断登录，由于提供了用户ID，所以直接查询是否选了这门课
        $sql3 = 'select * from hubu_choose_course where choose_course_choosed = '.$course_id.' and choose_course_student = '.$student_id;
        //echo $sql3;
        $result3 = mysql_query($sql3, $connect);//结果集3
        if (mysql_num_rows($result3) > 0){
            //用户选了这门课程
            //echo mysql_num_rows($result3);
            $sql4 = 'select * from hubu_chapter_progress where chapter_progress_student = '.$student_id.' and chapter_progress_course = '.$course_id;
            //echo $sql4;
            $result4 = mysql_query($sql4, $connect);//结果集4
            $chapter_progress_tmp = array();//存储章节进度信息临时数组
            $chapter_progress     = array();//存储章节进度信息最终数组
            //循环取出结果集中的数据
            while($tmp4 = mysql_fetch_assoc($result4)) {
                $chapter_progress_tmp[] = $tmp4;
            }
            //var_dump($chapter_progress_tmp);
            //数组调整为 chapter_id => 进度记录 这种形式
            /* foreach ($chapter_progress_tmp as $k => $v){
                $chapter_progress[$v['chapter_progress_chapter']] = $v['chapter_progress_state'];
            } */
            /**查询并计算该课程总得学习进度*/
            $sql5 = 'select sum(chapter_progress_state) from hubu_chapter_progress where chapter_progress_student = '.$student_id.' and chapter_progress_course = '.$course_id;
            $result5 = mysql_query($sql5, $connect);//结果集5
            while($tmp5 = mysql_fetch_assoc($result5)) {
                $course_progresss_tmp = $tmp5;
                //var_dump($course_progresss_tmp);
            }
            //echo $course_progresss_tmp['sum(chapter_progress_state)'];//学习进度求和
            //课程总的小节数
            $sql6 = 'select * from hubu_course_chapter where course_chapter_course_name = '.$course_id;
            $result6 = mysql_query($sql6, $connect);//结果集6
            $chapter_count = mysql_num_rows($result6);//课程小节数
            //echo $chapter_count;
            $course_progresss = round($course_progresss_tmp['sum(chapter_progress_state)']/($chapter_count*100),3)*100;//算平均评分,四舍五入一位小数,再换算成百分数形式
            //var_dump($course_progresss);
            //echo $course_progresss;
        }
        //var_dump($chapter_progress);
        
        $course_introduce['chapter_progress'] = $chapter_progress_tmp;
        $course_introduce['course_progress'] = $course_progresss;
        
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