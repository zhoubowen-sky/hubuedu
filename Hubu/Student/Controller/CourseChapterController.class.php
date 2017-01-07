<?php
// 课程章节页面的控制器
namespace Student\Controller;
use Think\Controller;
class CourseChapterController extends Controller {
	/**
	 * 用户点击课程后，例如点击“高等数学”，跳转到高等数学这门课程所有的章节列表页面
	 */
    function index(){
        header("Content-Type:text/html; charset=utf-8");//首页不乱码
		//echo "..................CourseChapter" ;
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
	function section_chapter(){
	    $section_chapter = getCourseSectionChapterList(1, 1);//高等数学
	    $this->assign('section_chapter',$section_chapter);
	    $this->display();
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