<?php
// 用户个人中心的控制器
namespace Student\Controller;
use Think\Controller;
class IController extends Controller {
    
    function index(){
        //先判断用户是否登陆
        if (isset($_SESSION['student_user_id'])){
            //用户已经登陆
            header("Content-Type:text/html; charset=utf-8");//不乱码
            $student_user_id = session('student_user_id');
            //show_bug($student_user_id);
            $myCourseID = M('ChooseCourse')->where("choose_course_student = $student_user_id")->select();//查询出所选的课程的ID已经评分等信息
            //show_bug($myCourseID);
            $myCourseInfo = array();//存储从数据库中查询到的已选课程的信息
            foreach ($myCourseID as $k => $v){
                $choose_course_choosed = $v['choose_course_choosed'];
                $myCourseInfo[$k] = D('CourseName')->where("course_name_id = $choose_course_choosed")->find();
                //把课程的评分加到$myCourseInfo里面去
                $myCourseInfo[$k]['course_name_score'] = (int)$myCourseID[$k]['choose_course_score'];
            }
            
            //show_bug($myCourseInfo);
            $this->assign('myCourseInfo',$myCourseInfo);
            
            $this->display();
        }else {
            $this->error('请先登录！',SITE_URL);
        }
    }
    
    /**
     * 删除已选的课程
     * @param 课程的ID信息 $course_name_id
     */
    function deleteChoosedCourse($course_name_id = 0){
        if ($course_name_id){
            //echo $course_name_id;
            $student_user_id = session('student_user_id');
            //执行删除操作
            $rzt = M('ChooseCourse')->where("choose_course_student = $student_user_id and choose_course_choosed = $course_name_id")->delete();
            if ($rzt){
                $this->success('退出课程成功！');
            }else {
                $this->error('出现未知错误，请联系管理员！');
            }
        }
    }
    
    function marking($course_name_id = 0){
        if ($course_name_id){
            if (!empty($_POST)){
                //echo $course_name_id;
                //show_bug($_POST);
                $score = M('ChooseCourse')->create();//收集表单数据
                $student_user_id = session('student_user_id');
                $rst = M('ChooseCourse')->where("choose_course_choosed = $course_name_id and choose_course_student = $student_user_id")->save();
                if ($rst){
                    $this->success('评分成功！');
                }else {
                    $this->error('评分失败！');
                }
            }
        }else {
            $this->error('出现未知错误，请联系管理员',SITE_URL);
        }
    }
    
}