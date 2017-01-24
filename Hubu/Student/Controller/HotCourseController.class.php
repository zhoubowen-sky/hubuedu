<?php
// 前台Student 热门课程的控制器,展示课程信息的模板
namespace Student\Controller;
use Think\Controller;
class HotCourseController extends Controller {
    /**
     * "热门课程"的模版页面，展示模版页面并向其输出数据
     */
    function hotCourse(){
        $hotCourse = D('HotCourse')->limit(8)->getField('hot_course_course_name',true);//查询出所有课程的ID信息,只查询出前8个
        //show_bug($hotCourse);
        //print_r($hotCourse);
        //通过上述ID，循环查询出所有课程的信息并存储到数组中
        $hot = array();
        foreach ($hotCourse as $k => $v){
            //使用SQL语句查询，或者使用TP自带的CURD方法操作，推荐使用TP的封装方法
            $info = D('CourseName')->where("course_name_id = $v")->find();
            //show_bug($info);
            //将上述查询到的结果存储到$hot数组里面
            $hot[$k] = $info;
        }
        //show_bug($hot);
        $this->assign('hot',$hot);
        $this->display();
    }
    
    function hotCourseList(){
        $hotCourse = D('HotCourse')->limit(8)->getField('hot_course_course_name',true);//查询出所有课程的ID信息,只查询出前8个
        //show_bug($hotCourse);
        //print_r($hotCourse);
        //通过上述ID，循环查询出所有课程的信息并存储到数组中
        $hot = array();
        foreach ($hotCourse as $k => $v){
            //使用SQL语句查询，或者使用TP自带的CURD方法操作，推荐使用TP的封装方法
            $info = D('CourseName')->where("course_name_id = $v")->find();
            //show_bug($info);
            //将上述查询到的结果存储到$hot数组里面
            $hot[$k] = $info;
        }
        //show_bug($hot);
        $this->assign('hot',$hot);
        $this->display();
        
    }
	
	
	
}