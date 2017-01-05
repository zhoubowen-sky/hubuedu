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
        //$this->display('course_name');
    }
    
    /*******说实在话，写下面这么多一模一样的方法实在没必要，可以只写一个方法，使用switch case 设置传入的参数不同，从而调用不同的指令*******/
    
    /**
     * 所有的课程
     */
    function all(){
        $m = M('CourseName');
        $where = '';
        $p = getpage($m,$where,5);
        $list = $m->field(true)->where($where)->select();
        $this->list = $list;
        $this->page = $p->show();
        $this->assign('course_name',$list);
        $this->display('course_name');
    }
    
    /**
     * 计算机类课程
     */
    function computer(){
        $m = M('CourseName');
        $where = 'course_name_class = 1';
        $p = getpage($m,$where,5);
        $list = $m->field(true)->where($where)->select();
        $this->list = $list;
        $this->page = $p->show();
        $this->assign('course_name',$list);
        $this->display('course_name');
    }
    
    /**
     * 经济管理
     */
    function ecoManagement(){
        $m = M('CourseName');
        $where = 'course_name_class = 2';
        $p = getpage($m,$where,5);
        $list = $m->field(true)->where($where)->select();
        $this->list = $list;
        $this->page = $p->show();
        $this->assign('course_name',$list);
        $this->display('course_name');
    }
    
    /**
     * 心理学
     */
    function psychology(){
        $m = M('CourseName');
        $where = 'course_name_class = 3';
        $p = getpage($m,$where,5);
        $list = $m->field(true)->where($where)->select();
        $this->list = $list;
        $this->page = $p->show();
        $this->assign('course_name',$list);
        $this->display('course_name');
    }
    
    /**
     * 外语
     */
    function foreignLanguage(){
        $m = M('CourseName');
        $where = 'course_name_class = 4';
        $p = getpage($m,$where,5);
        $list = $m->field(true)->where($where)->select();
        $this->list = $list;
        $this->page = $p->show();
        $this->assign('course_name',$list);
        $this->display('course_name');
    }
    
    /**
     * 文学历史
     */
    function literaryHistory(){
        $m = M('CourseName');
        $where = 'course_name_class = 5';
        $p = getpage($m,$where,5);
        $list = $m->field(true)->where($where)->select();
        $this->list = $list;
        $this->page = $p->show();
        $this->assign('course_name',$list);
        $this->display('course_name');
    }
    
    /**
     * 艺术设计
     */
    function artDesign(){
        $m = M('CourseName');
        $where = 'course_name_class = 6';
        $p = getpage($m,$where,5);
        $list = $m->field(true)->where($where)->select();
        $this->list = $list;
        $this->page = $p->show();
        $this->assign('course_name',$list);
        $this->display('course_name');
    }
    
    /**
     * 工学
     */
    function engineering(){
        $m = M('CourseName');
        $where = 'course_name_class = 7';
        $p = getpage($m,$where,5);
        $list = $m->field(true)->where($where)->select();
        $this->list = $list;
        $this->page = $p->show();
        $this->assign('course_name',$list);
        $this->display('course_name');
    }
    
    /**
     * 理学
     */
    function science(){
        $m = M('CourseName');
        $where = 'course_name_class = 8';
        $p = getpage($m,$where,5);
        $list = $m->field(true)->where($where)->select();
        $this->list = $list;
        $this->page = $p->show();
        $this->assign('course_name',$list);
        $this->display('course_name');
    }
    
    /**
     * 生命科学
     */
    function biomedicine(){
        $m = M('CourseName');
        $where = 'course_name_class = 9';
        $p = getpage($m,$where,5);
        $list = $m->field(true)->where($where)->select();
        $this->list = $list;
        $this->page = $p->show();
        $this->assign('course_name',$list);
        $this->display('course_name');
    }
    
    /**
     * 哲学
     */
    function philosophy(){
        $m = M('CourseName');
        $where = 'course_name_class = 10';
        $p = getpage($m,$where,5);
        $list = $m->field(true)->where($where)->select();
        $this->list = $list;
        $this->page = $p->show();
        $this->assign('course_name',$list);
        $this->display('course_name');
    }
    
    /**
     * 法学
     */
    function law(){
        $m = M('CourseName');
        $where = 'course_name_class = 11';
        $p = getpage($m,$where,5);
        $list = $m->field(true)->where($where)->select();
        $this->list = $list;
        $this->page = $p->show();
        $this->assign('course_name',$list);
        $this->display('course_name');
    }
    
    /**
     * 教育教学
     */
    function teachingMethod(){
        $m = M('CourseName');
        $where = 'course_name_class = 12';
        $p = getpage($m,$where,5);
        $list = $m->field(true)->where($where)->select();
        $this->list = $list;
        $this->page = $p->show();
        $this->assign('course_name',$list);
        $this->display('course_name');
    }
	
	
	
}