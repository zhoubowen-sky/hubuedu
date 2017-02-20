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
            
            /**从数据库中查询出用户的个人信息*/
            $studentUserInfo = D('StudentUser')->where("student_user_id = $student_user_id")->find();
            //$studentUserInfo['student_user_sex'] = (int)$studentUserInfo['student_user_sex'];//强制转换为int类型
            //show_bug($studentUserInfo);
            
            $myCourseID = M('ChooseCourse')->where("choose_course_student = $student_user_id")->select();//查询出所选的课程的ID已经评分等信息
            //show_bug($myCourseID);
            $myCourseInfo = array();//存储从数据库中查询到的已选课程的信息
            foreach ($myCourseID as $k => $v){
                $choose_course_choosed = $v['choose_course_choosed'];
                $myCourseInfo[$k] = D('CourseName')->where("course_name_id = $choose_course_choosed")->find();
                //把课程的评分加到$myCourseInfo里面去
                $myCourseInfo[$k]['course_name_score'] = (int)$myCourseID[$k]['choose_course_score'];
                //查询出课程的总的学习进度信息，并添加到 $myCourseInfo 里面
                $wheres = 'chapter_progress_student = '.$student_user_id.' and chapter_progress_course = '.$choose_course_choosed;
                $progress_tmp = M('ChapterProgress')->where($wheres)->sum('chapter_progress_state');
                $chapter_count = D('CourseChapter')->where("course_chapter_course_name = $choose_course_choosed")->count();//统计这门课程总节数
                /**计算出该生该课程的总学习进度    学习总进度 = 小节进度和/小节数   */
                $course_progress = round($progress_tmp/($chapter_count*100),3)*100;//算平均评分,四舍五入一位小数,再换算成百分数形式
                $myCourseInfo[$k]['course_progress'] = $course_progress;
            }
            
            //show_bug($myCourseInfo);
            $this->assign('myCourseInfo',$myCourseInfo);
            $this->assign('studentUserInfo',$studentUserInfo);//向页面输出用户信息
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
    
    /**
     * 给课程评分的方法
     * @param 课程的ID信息 $course_name_id
     */
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
    
    /**
     * 更改用户的密码
     */
    function updatePassword(){
        //show_bug($_POST);
        if (!empty($_POST)){
            //echo "提交了表单";
            $info = new \Model\StudentUserModel();
            $rst = $info->checkNamePwd(session('student_user_username'), $_POST['mpass']);//从session中获取当前用户的用户名
            //show_bug($rst);
            if ($rst){
                //存储表单接收到的数据
                $arr = array(
                    'student_user_pwd' => $_POST['renewpass'],/* 获取表单中的新密码 */
                );
                $student_user_id = session('student_user_id');//存储用户的ID信息
                $resault = D('StudentUser')->where("student_user_id = $student_user_id")->save($arr);
                //show_bug($resault);
                if ($resault){
                    $this->success('密码修改成功');
                }else {
                    $this->error('密码修改失败');
                }
            }else {
                $this->error('密码输入错误');
            }
            
        }else {
            $this->error('没有提交表单');
        }
    }
    
    /**
     * 更新用户的个人信息
     */
    function updateUserInfo(){
        //show_bug($_POST);
        if (!empty($_FILES['student_user_pic']['tmp_name'])){
                //选择了头像图片
                //自定义文件接收相关配置
                $config = array(
                    'rootPath'      =>  'Hubu/Public/', //保存根路径,Andim目录下面public目录定义为Admin的根目录，这里的路径设置是以admin.php所在路径为依据设置
                    'savePath'      =>  'Uploads/', //保存路径为Uploads，TP框架会自动生成如2016-12-18的日期文件夹
                );
                //print_r($_FILES);//是个二维数组
                $upload = new \Think\Upload($config);//实例化Upload对象
                //show_bug($upload);
                $z = $upload->uploadOne($_FILES['student_user_pic']);//执行上传操作
                //print_r($z);
                //show_bug($z);
                if (!$z){
                    //show_bug($upload->getError());
                    //$this->error($upload->getError());//输出错误
                    $this->error('头像上传失败');
                } else {
                    //$this->success("头像上传成功！");
                    echo "头像上传成功！";
                }
                $_POST['student_user_pic'] = $z['savepath'].$z['savename'];/**这里存储用户头像的文件路径*/
                $_POST['student_user_time'] = date('Y-m-d H:i:s');
                $student_user_id = session('student_user_id');//存储用户的ID信息
                $studentUserInfo = D('StudentUser')->create();
                //show_bug($studentUserInfo);
                //show_bug($_POST);
                $rst = D('StudentUser')->where("student_user_id = $student_user_id")->save();//更新数据库
                if ($rst){
                    $this->success('数据更新成功！');
                }else {
                    //show_bug($rst);
                    $this->error('数据更新失败！');
                }
        }else {
            $this->error('没有选择头像文件');
        }
    }
    
    
    
    
    
    
    
    
    
}