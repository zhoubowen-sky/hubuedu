<?php
// 播放视频的控制器
namespace Student\Controller;
use Think\Controller;
class VideoController extends Controller {
	/**
	 * 展示视频播放页的方法
	 */
    function index(){
        header("Content-Type:text/html; charset=utf-8");//首页不乱码
		$this->display('index');
	}
	
	/**
	 * 视频播放模板展示与控制
	 */
	function videoPlayer(){
	    $this->display();
	}
	
	/**
	 * 展示学习资料的模板
	 */
	function studyingData(){
	    echo "学习资料";
	}
	
	/**
	 * 展示PPT的方法
	 */
	function showPPT(){
	    echo "showPPT";
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
	
}