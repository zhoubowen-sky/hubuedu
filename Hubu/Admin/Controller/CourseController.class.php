<?php
// 后台管理课程的控制器
namespace Admin\Controller;
use Think\Controller;
class CourseController extends Controller {
    
    /**
     * TODO 输出课程的列表信息
     */
    function courseList(){
        if(!empty($_POST)){
            //有表单数据传递进来
            //post表单传递进来的课程类别值
            $course_name_class = $_POST['course_name_class'];
            //show_bug($_POST);
            //show_bug($course_name_class);
            if($course_name_class != null){
                //传进来的值不为空
                $m = M('CourseName');
                $where = "course_name_class = $course_name_class";
                $p = getpage($m,$where,5);
                $course_name = $m->field(true)->where($where)->select();
                $this->course_name = $course_name;
                $this->page = $p->show();
                $this->assign('course_name',$course_name);
                $this->display();
            }else {
                //传进来的值为空，即默认选了全选
                $m = M('CourseName');
                $where = '';
                $p = getpage($m,$where,5);
                $course_name = $m->field(true)->where($where)->select();
                $this->course_name = $course_name;
                $this->page = $p->show();
                $this->assign('course_name',$course_name);
                $this->display();
            }
        }else {
            //没有表单提交
            //echo "无表单数据提交";
            $m = M('CourseName');
            $where = '';
            $p = getpage($m,$where,5);
            $course_name = $m->field(true)->where($where)->select();
            $this->course_name = $course_name;
            $this->page = $p->show();
            $this->assign('course_name',$course_name);
            $this->display();
        }
    }
    
    function showCourseChapter(){
        
    }
	
    function updateCourseInfo(){
        
    }
    
    
    
    
    
    
    
    
    
	
	
	
}