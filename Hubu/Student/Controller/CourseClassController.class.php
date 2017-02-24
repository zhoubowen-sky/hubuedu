<?php
// 课程类别的控制器，数学类，艺术设计类，计算机类
namespace Student\Controller;
use Think\Controller;
class CourseClassController extends Controller {
    
    //空操作的方法
    function _empty(){
        echo '服务器繁忙，请稍后再试...';
    }
    
    /**
     * 读取数据库中课程类别的信息
     * 读出有数据库表hubu_course_class多少种类别
     */
    function getCourseClass(){
        $info = D('CourseClass');
        //show_bug($info);
        $course_class = $info->select();
        //show_bug($z);
        $this->assign('course_class',$course_class);//将数据输出到模板引擎
        
    }
    
}