<?php
// 播放视频的控制器
namespace Student\Controller;
use Think\Controller;
class VideoController extends Controller {
    
    //空操作的方法
    function _empty(){
        echo '服务器繁忙，请稍后再试...';
    }
    
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
            $this->error('请登陆后再查看视频',SITE_URL);
        }
        
        //echo $course_name.'<br>';
        //echo $id;
        //根据传进来的参数，获取课程的信息，该节视频的信息，该门课程的信息
        //$course_chapter_sql = "select * from hubu_course_chapter where course_chapter_name = $course_name and course_chapter_id = $id";
//         $course_info = getCourseSectionChapterList($course_name);
//         //show_bug($course_info);
//         /**下面用循环将$course_info 里面的url地址统一用url安全编码方法进行编码，同时将课程进度记录要用的参数拼接进去**/
//         foreach ($course_info as $k => &$v){
//             //show_bug($v);
//             foreach ($v as $kk => &$vv){
//                 //执行url编码
//                 //echo $vv['course_chapter_video_url'].'<br>';
//                 $vv['course_chapter_video_url'] = urlsafe_b64encode(ADMIN_IMG_UPLOADS.$vv['course_chapter_video_url']);
//                 //echo $vv['course_chapter_video_url'];
                
//                 /**课程进度记录相关的代码*/
//                 //课程进度记录需要四个参数，课程ID，小节ID，用户ID，还有播放进度，将其加入到下面的section_chapter中
//                 //需要添加的信息有 课程ID 用户ID ，小节ID已经有了,
//                 $vv['course_id'] = $course_name;
//                 $vv['student_id'] = $_SESSION['student_user_id'];
//                 $vv['chapter_id'] = $vv['course_chapter_id'];//换个名字在存储一次
                
//                 //该小节课程之前的学习进度
//                 $wheres = 'chapter_progress_student = '.$_SESSION['student_user_id'].' and chapter_progress_course = '.$course_name.' and chapter_progress_chapter = '.$vv['course_chapter_id'];
//                 //echo $wheres;
//                 $chapter_current_time_tmp = M('ChapterProgress')->where($wheres)->find();
//                 //show_bug($chapter_current_time_tmp);
//                 //echo $chapter_current_time_tmp['chapter_progress_current_time'];
//                 $vv['chapter_current_time'] = (int)$chapter_current_time_tmp['chapter_progress_current_time'];
                
//             }
//             unset($vv);//取消引用
//         }
//         unset($v);//取消引用
        
        $chapter_info = D('CourseChapter')->where("course_chapter_course_name = $course_name and course_chapter_id = $id")->find(); /* query($course_chapter_sql); */
        //show_bug($chapter_info);
        
        //echo $chapter_info['course_chapter_video_url'];//数据库中存储的video视频的相对地址
        $chapter_info['course_chapter_video_url'] = ADMIN_IMG_UPLOADS.$chapter_info['course_chapter_video_url'];//拼接成完整的url地址
        //echo $chapter_info['course_chapter_video_url'];
        $chapter_info['course_chapter_video_url'] = urlsafe_b64encode($chapter_info['course_chapter_video_url']);//url编码
        //echo $chapter_info['course_chapter_video_url'];
        //echo urlsafe_b64decode($chapter_info['course_chapter_video_url']);
        //show_bug($chapter_info);
        //show_bug($course_info);
        //课程进度记录需要四个参数，课程ID，小节ID，用户ID，还有播放进度，将其加入到下面的$chapter_info中
        //需要添加的信息有 课程ID 用户ID ，小节ID已经有了,
        $chapter_info['course_id']  = $course_name;
        $chapter_info['student_id'] = $_SESSION['student_user_id'];
        $chapter_info['chapter_id'] = $chapter_info['course_chapter_id'];
        //该小节课程之前的学习进度
        $wheres = 'chapter_progress_student = '.$_SESSION['student_user_id'].' and chapter_progress_course = '.$course_name.' and chapter_progress_chapter = '.$chapter_info['course_chapter_id'];
        //echo $wheres;
        $chapter_current_time_tmp = M('ChapterProgress')->where($wheres)->find();
        $chapter_info['chapter_current_time'] = (int)$chapter_current_time_tmp['chapter_progress_current_time'];
        //show_bug($chapter_info);
        
        //section_chapter中添加了进度记录的几个参数，因为在模板中要用到
        $this->assign('chapter_info',$chapter_info);
//        $this->assign('section_chapter',$course_info);
		$this->display('index');
	}
	
	/**
	 * 视频播放模板展示与控制，传入的参数是视频的url地址，这个url地址是从Uploads以后的地址
	 * ADMIN_IMG_UPLOADS这个常量与其拼接之后才是完整的url地址
	 * 这里强调一下，因为url地址里面有/符号，所以需要用到一种方案将斜杠/以及其他字符转变为其他的字符串，随后使用的时候将其解码
	 */
	function videoPlayer($video_url = '',$course_id = 0 ,$chapter_id = 0 ,$student_id = 0 ,$chapter_current_time = 0){
	    //echo $video_url;
	    //echo urlencode($video_url);//
	    //echo urlsafe_b64decode($video_url);//url解码
	    $video_url = urlsafe_b64decode($video_url);
	    //echo $video_url;
	    
	    /**此方法还承担着接收以及输出相关课程小节学习进度记录的资料*/
	    //echo $chapter_current_time;
	    //存储用get方式传进来的参数的值
	    $parameter = array(
	        'chapter_id' => $chapter_id,
	        'student_id' => $student_id,
	        'course_id'  => $course_id,
	        'chapter_current_time' => $chapter_current_time
	    );
	    //show_bug($parameter);
	    
	    //获取该课程的章节列表信息输出到模板页面
	    $course_info = A('Student/Video')->getCourseInfo($course_id);
	    //show_bug($course_info);
	    $this->assign('section_chapter',$course_info);
	    
	    $this->assign('parameter',$parameter);
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
	
	/**
	 * 获取该门课程的列表信息并且添加数据库中该课程之前的学习进度记录到其中
	 * @param 符合要求的数组 array $course_name_id
	 */
	function getCourseInfo($course_name_id){
	    $course_info = getCourseSectionChapterList($course_name_id);
	    //show_bug($course_info);
	    /**下面用循环将$course_info 里面的url地址统一用url安全编码方法进行编码，同时将课程进度记录要用的参数拼接进去**/
	    foreach ($course_info as $k => &$v){
	        //show_bug($v);
	        foreach ($v as $kk => &$vv){
	            //执行url编码
	            //echo $vv['course_chapter_video_url'].'<br>';
	            $vv['course_chapter_video_url'] = urlsafe_b64encode(ADMIN_IMG_UPLOADS.$vv['course_chapter_video_url']);
	            //echo $vv['course_chapter_video_url'];
	    
	            /**课程进度记录相关的代码*/
	            //课程进度记录需要四个参数，课程ID，小节ID，用户ID，还有播放进度，将其加入到下面的section_chapter中
	            //需要添加的信息有 课程ID 用户ID ，小节ID已经有了,
	            $vv['course_id'] = $course_name_id;
	            $vv['student_id'] = $_SESSION['student_user_id'];
	            $vv['chapter_id'] = $vv['course_chapter_id'];//换个名字在存储一次
	    
	            //该小节课程之前的学习进度
	            $wheres = 'chapter_progress_student = '.$_SESSION['student_user_id'].' and chapter_progress_course = '.$course_name_id.' and chapter_progress_chapter = '.$vv['course_chapter_id'];
	            //echo $wheres;
	            $chapter_current_time_tmp = M('ChapterProgress')->where($wheres)->find();
	            //show_bug($chapter_current_time_tmp);
	            //echo $chapter_current_time_tmp['chapter_progress_current_time'];
	            $vv['chapter_current_time'] = (int)$chapter_current_time_tmp['chapter_progress_current_time'];
	    
	        }
	        unset($vv);//取消引用
	    }
	    unset($v);//取消引用
	    return $course_info;
	}
	
	
	
	
	
	
	
	
	
	
	
	
}