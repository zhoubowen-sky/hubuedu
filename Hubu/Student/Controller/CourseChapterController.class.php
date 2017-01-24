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
		/**通过session值查询数据库中的信息，判断用户是否选了这门课程**/
		//echo session('student_user_id');
		if (isset($_SESSION['student_user_id'])){
		    //用户已经登陆，查询数据表hubu_choose_course看用户有没有选择这门课
		    $user_id = session('student_user_id');
		    $check = M('ChooseCourse')->where("choose_course_choosed = $course_name_id and choose_course_student = $user_id")->find();
		    //show_bug($check);
		    if ($check){
		        //echo "真";
		        $this->assign('check',true);
		    }else {
		        //echo "假";
		        $this->assign('check',false);
		    }
		}
		
		/**查询出课程学习人数，课程节数，总时长等信息，输出到模板**/
		$choosed_count = M('ChooseCourse')->where("choose_course_choosed = $course_name_id")->count();//已选这门课程总人数
		//show_bug($choosed_count);
		$chapter_count = D('CourseChapter')->where("course_chapter_course_name = $course_name_id")->count();//统计这门课程总节数
		//show_bug($chapter_count);
		$sql = "SELECT SUM(choose_course_score) FROM hubu_choose_course WHERE choose_course_choosed = $course_name_id";//查询出分数求和值
		$course_score = M('ChooseCourse')->query($sql);//查询出来的结果是个二维数组
		//show_bug($course_score[0]['sum(choose_course_score)']);
		$course_score = round($course_score[0]['sum(choose_course_score)']/$choosed_count , 1) ;//算平均评分,四舍五入一位小数
		//show_bug($course_score);
		$this->assign('course_score',$course_score);
		$this->assign('choosed_count',$choosed_count);
		$this->assign('chapter_count',$chapter_count);
		$this->assign('course_info',$course_info);//将信息输出到模板
		$this->display('index');
	}
	
	/**
	 * 将该课程添加到已选课程
	 * @param 课程的ID信息 $course_name_id
	 */
	function chooseCourse($course_name_id = 0){
	    if($course_name_id){
	        $data = array(
	            'choose_course_student' => session('student_user_id'),
	            'choose_course_choosed' => $course_name_id,
	        );
	        //show_bug($data);
	        $rst = M('ChooseCourse')->add($data);
	        if ($rst){
	            $this->success('添加成功');
	        }else {
	            $this->error('添加失败');
	        }
	    }
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
	/**
	 * 查询出这门课的简介，课程名等等信息$course_section_course_name ,$course_chapter_course_name
	 * @param 传入的是课程的ID $course_name_id
	 */
	function section_chapter($course_name_id = 0){
	    //$$course_name_id指的是课程的ID信息
	    if($course_name_id > 0){
	        //echo $course_name_id;
    	    $section_chapter = getCourseSectionChapterList($course_name_id);//高等数学1,1    信号系统2,2  
    	    //show_bug($section_chapter);//查看从数据库中查询出来的信息是否正确
    	    $this->assign('section_chapter',$section_chapter);
    	    $this->display();
	    }else {
	        echo "数据查询不成功，联系管理员处理";
	    }
	    
	}
	
	function test(){
	    show_bug(getCourseSectionChapterList(2,2));
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