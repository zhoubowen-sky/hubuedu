<?php
// 课程章节页面的控制器
namespace Student\Controller;
use Think\Controller;
class CourseChapterController extends Controller {
	/**
	 * 用户点击课程后，例如点击“高等数学”，跳转到高等数学这门课程所有的章节列表页面
	 */
    function index($course_name_id){
        //echo $course_name_id;
        header("Content-Type:text/html; charset=utf-8");//首页不乱码
		//这里传进来的$course_name_id是课程的ID值
		//根据上述ID查询出该课程的名称等信息
		$info = D('CourseName');
		
		//show_bug($info);
		$course_info = $info->where("course_name_id = $course_name_id")->find();
		//show_bug($course_info);
		$this->assign('course_info',$course_info);//将信息输出到模板
		
		$this->display('index');
	}
	
	/**
	 * 展示章节section,以及该章节下所有小节chapter的信息
	 * 我这里section表示章，chapter表示节
	 * 要展示的效果如下：
	 * 第一章 课程介绍
	 *     1.0映射与函数
	 *     1.1无穷小与无穷大
	 * 第二章 xxxxx
	 * 上述使用的是一个.html模板
	 */
	function section_chapter($course_name_id = 0){
	    //$$course_name_id指的是课程的ID信息
	    if($course_name_id){
	        //echo $course_name_id;
    	    $section_chapter = getCourseSectionChapterList($course_name_id);//高等数学1，信号系统2
    	    //show_bug($section_chapter);//查看从数据库中查询出来的信息是否正确
    	    $this->assign('section_chapter',$section_chapter);
    	    $this->display();
	    }else {
	        echo "数据查询不成功，联系管理员处理";
	    }
	    
	}
	
	
	/**
	 * 展示这个页面的评论板块
	 * 用iframe嵌入
	 */
	function comment(){
	    $this->display();
	}
	
	/**
	 * 展示这个页面的笔记板块
	 * 同上，用iframe嵌入
	 */
	function note(){
	    $this->display();
	}
	
	
	
}