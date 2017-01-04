<?php
// 课程的控制器,展示课程信息的模板
namespace Student\Controller;
use Think\Controller;
class CourseController extends Controller {
    /**
     * "课程"选项的网页模板展示，与IndexController同等级别
     */
    function index(){
        //echo "这是课程展示页面";
        //将课程类别信息用模板输入到页面，调用CourseClass里面的方法,这输入跨控制器调用，使用A方法
        //$course_class = A('CourseClass');
        //show_bug($course_class);
        //$course_class->getCourseClass();//调用CourseClass控制器里面的getCourseClass()方法
        
        //将所有课程名称信息输出到模板，方法同上所示
        //$course_name = A('CourseName');
        //show_bug($course_name);
        //$course_name->getCourseName();
        
        $this->display();
    }
	
	
	
}