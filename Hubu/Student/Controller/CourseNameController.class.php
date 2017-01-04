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
    

    /**
     * 所有的课程
     */
    function all(){
        $info = D('CourseName');
        //show_bug($info);
        $course_name = $info->select();//获取数据库中的全部数据
        //show_bug($course_name);
        $this->assign('course_name',$course_name);
    }
    
    /**
     * 计算机类课程
     */
    function computer(){
    
    }
    
    /**
     * 经济管理
     */
    function ecoManagement(){
    
    }
    
    /**
     * 心理学
     */
    function psychology(){
    
    }
    
    /**
     * 外语
     */
    function foreignLanguage(){
    
    }
    
    /**
     * 文学历史
     */
    function literaryHistory(){
    
    }
    
    /**
     * 艺术设计
     */
    function artDesign(){
         
    }
    
    /**
     * 工学
     */
    function engineering(){
         
    }
    
    /**
     * 理学
     */
    function science(){
         
    }
    
    /**
     * 生命科学
     */
    function biomedicine(){
         
    }
    
    /**
     * 哲学
     */
    function philosophy(){
         
    }
    
    /**
     * 法学
     */
    function law(){
         
    }
    
    /**
     * 教育教学
     */
    function teachingMethod(){
         
    }
	
	
	
}