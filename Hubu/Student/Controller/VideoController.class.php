<?php
// 播放视频的控制器
namespace Student\Controller;
use Think\Controller;
class VideoController extends Controller {
	/**
	 * 展示视频播放页的方法，并将课程的参数传递进来
	 * @param 课程名的id $course_name
	 * @param 课程小节chapter的id $id
	 */
    function index($course_name,$id){
        //echo $course_name;
        //echo $id;
        header("Content-Type:text/html; charset=utf-8");//首页不乱码
        
        /**通过session值查询数据库中的信息，判断用户是否选了这门课程**/
        //echo session('student_user_id');
        if (isset($_SESSION['student_user_id'])){
            //用户已经登陆，查询数据表hubu_choose_course看用户有没有选择这门课
            $user_id = session('student_user_id');
            $check = M('ChooseCourse')->where("choose_course_choosed = $course_name and choose_course_student = $user_id")->find();
            //show_bug($check);
            if ($check){
                //echo "真";
                
            }else {
                //echo "假";
                //用户没有选择这门课程，弹出提示让他选择，否则不能观看视频
                $this->error('您还没有选择这门课程，不能观看视频',SITE_URL);
            }
        }else {
            $this->error('请登陆后再查看视频');
        }
        
        //echo $course_name.'<br>';
        //echo $id;
        //根据传进来的参数，获取课程的信息，该节视频的信息，该门课程的信息
        //$course_chapter_sql = "select * from hubu_course_chapter where course_chapter_name = $course_name and course_chapter_id = $id";
        $course_info = getCourseSectionChapterList($course_name);
        //show_bug($course_info);
        /**下面用循环将$course_info 里面的url地址统一用url安全编码方法进行编码**/
        foreach ($course_info as $k => &$v){
            //show_bug($v);
            foreach ($v as $kk => &$vv){
                //执行url编码
                //echo $vv['course_chapter_video_url'].'<br>';
                $vv['course_chapter_video_url'] = urlsafe_b64encode(ADMIN_IMG_UPLOADS.$vv['course_chapter_video_url']);
                //echo $vv['course_chapter_video_url'];
            }
            unset($vv);//取消引用
        }
        unset($v);//取消引用
        
        $chapter_info = D('CourseChapter')->where("course_chapter_course_name = $course_name and course_chapter_id = $id")->find(); /* query($course_chapter_sql); */
        //show_bug($chapter_info);
        
        //echo $chapter_info['course_chapter_video_url'];//数据库中存储的video视频的相对地址
        $chapter_info['course_chapter_video_url'] = ADMIN_IMG_UPLOADS.$chapter_info['course_chapter_video_url'];//拼接成完整的url地址
        //echo $chapter_info['course_chapter_video_url'];
        $chapter_info['course_chapter_video_url'] = urlsafe_b64encode($chapter_info['course_chapter_video_url']);//url编码
        //echo $chapter_info['course_chapter_video_url'];
        //echo urlsafe_b64decode($chapter_info['course_chapter_video_url']);
        $this->assign('chapter_info',$chapter_info);
        $this->assign('section_chapter',$course_info);
		$this->display('index');
	}
	
	/**
	 * 视频播放模板展示与控制，传入的参数是视频的url地址，这个url地址是从Uploads以后的地址
	 * ADMIN_IMG_UPLOADS这个常量与其拼接之后才是完整的url地址
	 * 这里强调一下，因为url地址里面有/符号，所以需要用到一种方案将斜杠/以及其他字符转变为其他的字符串，随后使用的时候将其解码
	 */
	function videoPlayer($video_url = ''){
	    //echo $video_url;
	    //echo urlencode($video_url);//
	    //echo urlsafe_b64decode($video_url);//url解码
	    $video_url = urlsafe_b64decode($video_url);
	    //echo $video_url;
	    $this->assign('video_url',$video_url);
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
	/* function section_chapter(){
	    $section_chapter = getCourseSectionChapterList(2);//高等数学
	    $this->assign('section_chapter',$section_chapter);
	    $this->display();
	} */
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}