<?php
// 播放视频的控制器
namespace Student\Controller;
use Think\Controller;
class VideoController extends Controller {
	/**
	 * 展示视频播放页的方法，并将课程的参数传递进来
	 * @param 课程名的id $course_name
	 * @param 课程章节的id $id
	 */
    function index($course_name,$id){
        //echo $course_name;
        //echo $id;
        header("Content-Type:text/html; charset=utf-8");//首页不乱码
        //echo $course_name.'<br>';
        //echo $id;
        //根据传进来的参数，获取课程的信息，该节视频的信息，该门课程的信息
        //$course_chapter_sql = "select * from hubu_course_chapter where course_chapter_name = $course_name and course_chapter_id = $id";
        $course_info = getCourseSectionChapterList($course_name);
        $chapter_info = D('CourseChapter')->where("course_chapter_course_name = $course_name and course_chapter_id = $id")->find(); /* query($course_chapter_sql); */
        //show_bug($chapter_info);
        //show_bug($course_info);
        $this->assign('chapter_info',$chapter_info);
        $this->assign('section_chapter',$course_info);
		$this->display('index');
	}
	
	/**
	 * 视频播放模板展示与控制
	 */
	/* function videoPlayer($video_url = ''){
	    echo $video_url;
	    $this->assign('video_url',$video_url);
	    $this->display();
	} */
	
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
	/* function section_chapter(){
	    $section_chapter = getCourseSectionChapterList(2);//高等数学
	    $this->assign('section_chapter',$section_chapter);
	    $this->display();
	} */
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}