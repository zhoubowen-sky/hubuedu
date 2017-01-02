<?php
// 课程名称的控制器,展示所有课程信息
namespace Student\Controller;
use Think\Controller;
class CourseNameController extends Controller {
    /**
     * 从数据库中获取所有的课程名称，并输出到模板
     * 对应的数据表为hubu_course_name
     */
    function getCourseName(){
        $info = D('CourseName');
        //show_bug($info);
        $course_name = $info->select();//获取数据库中的全部数据
        //show_bug($course_name);
        $this->assign('course_name',$course_name);
    }
	
	
	
}