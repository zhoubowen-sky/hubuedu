<?php
// 后台管理课程的控制器
namespace Admin\Controller;
use Think\Controller;
class CourseController extends Controller {
    
    /**
     * TODO 输出课程的列表信息
     */
    function courseList(){
        if(!empty($_POST)){
            //有表单数据传递进来
            //post表单传递进来的课程类别值
            $course_name_class = $_POST['course_name_class'];
            //show_bug($_POST);
            //show_bug($course_name_class);
            if($course_name_class != null){
                //传进来的值不为空
                $m = M('CourseName');
                $where = "course_name_class = $course_name_class";
                $p = getpage($m,$where,5);
                $course_name = $m->field(true)->where($where)->select();
                $this->course_name = $course_name;
                $this->page = $p->show();
                $this->assign('course_name',$course_name);
                $this->display();
            }else {
                //传进来的值为空，即默认选了全选
                $m = M('CourseName');
                $where = '';
                $p = getpage($m,$where,5);
                $course_name = $m->field(true)->where($where)->select();
                $this->course_name = $course_name;
                $this->page = $p->show();
                $this->assign('course_name',$course_name);
                $this->display();
            }
        }else {
            //没有表单提交
            //echo "无表单数据提交";
            $m = M('CourseName');
            $where = '';
            $p = getpage($m,$where,5);
            $course_name = $m->field(true)->where($where)->select();
            $this->course_name = $course_name;
            $this->page = $p->show();
            //show_bug($course_name);
            $this->assign('course_name',$course_name);
            $this->display();
        }
    }
    
    /**
     * TODO 查看课程的章节信息的方法
     * @param 课程信息这条记录在数据库中的ID值 $course_name_id
     */
    function showCourseChapter($course_name_id = 0){
        if($course_name_id){
            //有参数传递进来，查询数据库中该课程章节的所有信息，并输出到模板展示
            //echo $course_name_id;
            $section_chapter = getCourseSectionChapterList($course_name_id);
            //show_bug($section_chapter);
            $this->assign('section_chapter',$section_chapter);
            $this->display();
        }else {
            echo "出现错误，请联系网站管理员。";
        }
    }
	
    /**
     * TODO 修改课程节的信息
     * @param 课程节的id course_chapter_id
     */
    function updateCourseChapterInfo($course_chapter_id = 0){
        //echo $course_chapter_id;
        //表单为空则表示用户没有提交表单
        if(empty($_POST)){
            if($course_chapter_id){
                //用传进来的id查询出该节信息，并且输出到模板文件
                //下面这个不要使用select，否则生成的就是一个二维数组，find查询出来的的是一维数组
                $course_chapter_info = D('CourseChapter')->where("course_chapter_id = $course_chapter_id")->find();
                //show_bug($course_chapter_info);
                $this->assign('course_chapter_info',$course_chapter_info);
                //print_r($rst);
                $this->display('updateCourseChapterInfo');
                
                //$info = D('CourseChapter')->create();
                //show_bug($info);
            }else {
                echo "出现错误，请联系网站管理员。";
                //show_bug($_POST);
            }
        }else {
            //有表单提交，收集表单数据并且更新数据库
            //show_bug($_POST);
            $info = D('CourseChapter')->create();
            //show_bug($info);
            $rst = D('CourseChapter')->where("course_chapter_id = $course_chapter_id")->save();//更新数据库中的对应数据
            //show_bug($rst);
            if ($rst){
                $this->success('信息修改成功');
            }else {
                $this->error('信息修改失败，或者未修改');
            }
        }
        
    }
    
    /**
     * TODO 更新视频
     * @param number $course_chapter_id
     */
    function updateCourseChapterInfo_video($course_chapter_id = 0){
        //echo $course_chapter_id;
            if ($course_chapter_id){
                //传入的参数为真，执行更新操作
                //检测是否有附件上传
                //show_bug($_FILES);
                if(!empty($_FILES)){
                    //echo "有附件上传";
                    //自定义文件接收相关配置
                    $config = array(
                        'rootPath'      =>  'Hubu/Public/', //保存根路径,Andim目录下面public目录定义为Admin的根目录，这里的路径设置是以admin.php所在路径为依据设置
                        'savePath'      =>  'Uploads/', //保存路径为Uploads，TP框架会自动生成如2016-12-18的日期文件夹
                    );
                    //print_r($_FILES);//是个二维数组
                    $upload = new \Think\Upload($config);//实例化Upload对象
                    //show_bug($upload);
                    $z = $upload->uploadOne($_FILES['course_chapter_video_url']);//执行上传操作
                    //print_r($z);
                    //show_bug($z);
                    if (!$z){
                        //show_bug($upload->getError());
                        $this->error($upload->getError());//输出错误
                    } else {
                        //$this->success("文件上传成功！");
                        echo "文件上传成功！";
                    }
                }
                $_POST['course_chapter_video_url'] = $z['savepath'].$z['savename'];/**这里存储用户头像的文件路径*/
                $_POST['course_chapter_time'] = date('Y-m-d H:i:s');
                $imgTurnInfo = D('CourseChapter')->create();//收集表单数据,create不能收集文件数据，所以要单独添加到$_POST里面
                //show_bug($imgTurnInfo);
                //将数据存储到数据库里面
                $rst = D('CourseChapter')->where("course_chapter_id = $course_chapter_id")->save($imgTurnInfo);//如果添加成功返回的是这条记录的ID
                //show_bug($rst);
                if ($rst){
                    $this->success('数据更新成功！');
                }else {
                    $this->error('数据更新失败！');
                }
            }else {
                $this->error('程序出现错误，请联系管理员');
            }
    }
        
    
    
    /**
     * TODO 更新PPT
     * @param number $course_chapter_id
     */
    function updateCourseChapterInfo_ppt($course_chapter_id = 0){
        //echo $course_chapter_id;
            if ($course_chapter_id){
                //传入的参数为真，执行更新操作
                //检测是否有附件上传
                //show_bug($_FILES);
                if(!empty($_FILES)){
                    //echo "有附件上传";
                    //自定义文件接收相关配置
                    $config = array(
                        'rootPath'      =>  'Hubu/Public/', //保存根路径,Andim目录下面public目录定义为Admin的根目录，这里的路径设置是以admin.php所在路径为依据设置
                        'savePath'      =>  'Uploads/', //保存路径为Uploads，TP框架会自动生成如2016-12-18的日期文件夹
                    );
                    //print_r($_FILES);//是个二维数组
                    $upload = new \Think\Upload($config);//实例化Upload对象
                    //show_bug($upload);
                    $z = $upload->uploadOne($_FILES['course_chapter_ppt_url']);//执行上传操作
                    //print_r($z);
                    //show_bug($z);
                    if (!$z){
                        //show_bug($upload->getError());
                        $this->error($upload->getError());//输出错误
                    } else {
                        //$this->success("文件上传成功！");
                        echo "视频文件上传成功！";
                    }
                }
                $_POST['course_chapter_ppt_url'] = $z['savepath'].$z['savename'];/**这里存储用户头像的文件路径*/
                $_POST['course_chapter_time'] = date('Y-m-d H:i:s');
                $imgTurnInfo = D('CourseChapter')->create();//收集表单数据,create不能收集文件数据，所以要单独添加到$_POST里面
                //show_bug($imgTurnInfo);
                //将数据存储到数据库里面
                $rst = D('CourseChapter')->where("course_chapter_id = $course_chapter_id")->save($imgTurnInfo);//如果添加成功返回的是这条记录的ID
                //show_bug($rst);
                if ($rst){
                    $this->success('数据更新成功！');
                }else {
                    $this->error('数据更新失败！');
                }
            }else {
                $this->error('程序出现错误，请联系管理员');
            }
        
    }
    
    /**
     * TODO 更新其他附加资料
     * @param number $course_chapter_id
     */
    function updateCourseChapterInfo_else($course_chapter_id = 0){
        if ($course_chapter_id){
            //传入的参数为真，执行更新操作
        }
    }
    
    /**
     * TODO 修改课程名称简介以及其他信息的方法
     * @param number $course_name_id
     */
    function updateCourseInfo($course_name_id = 0){
        //判断有无表单提交
        if (empty($_POST)){
            //echo $course_name_id;
            if($course_name_id){
                $courseinfo = D('CourseName')->where("course_name_id = $course_name_id")->find();
                //show_bug($courseinfo);
                $this->assign('courseinfo',$courseinfo);
                $this->display();
            }else {
                $this->error('程序出现错误');
            }
        }else {
            //有表单提交，收集表单数据
            if(empty($_FILES['course_name_pic']['tmp_name'])){
                //没有附件上传
                $this->error('没有选择课程图片');
            }else {
                //选择了课程图片
                //自定义文件接收相关配置
                $config = array(
                    'rootPath'      =>  'Hubu/Public/', //保存根路径,Andim目录下面public目录定义为Admin的根目录，这里的路径设置是以admin.php所在路径为依据设置
                    'savePath'      =>  'Uploads/', //保存路径为Uploads，TP框架会自动生成如2016-12-18的日期文件夹
                );
                //print_r($_FILES);//是个二维数组
                $upload = new \Think\Upload($config);//实例化Upload对象
                //show_bug($upload);
                $z = $upload->uploadOne($_FILES['course_name_pic']);//执行上传操作
                //print_r($z);
                //show_bug($z);
                if (!$z){
                    //show_bug($upload->getError());
                    $this->error($upload->getError());//输出错误
                } else {
                    //$this->success("文件上传成功！");
                    echo "文件上传成功！";
                }
                }
                $_POST['course_name_pic'] = $z['savepath'].$z['savename'];/**这里存储用户头像的文件路径*/
                $_POST['course_name_time'] = date('Y-m-d H:i:s');
                $course = D('CourseName')->create();
                //show_bug($course);
                //show_bug($_POST);
                $rst = D('CourseName')->where("course_name_id = $course_name_id")->save();//更新数据库
                if ($rst){
                    $this->success('数据更新成功！');
                }else {
                    $this->error('数据更新失败！');
                }
            }
        
        
    }
    
    function addCourse(){
        
    }
    
    /**
     * TODO 删除课程的所有信息，包括所有小节信息
     * @param number $course_name_id
     */
    function deleteCourse($course_name_id = 0){
        if ($course_name_id){
            //删除课程以及该课程的所有章节信息
            $rst_course = D('CourseName')->where("course_name_id = $course_name_id")->delete();//删除课程信息
            $rst_chapter = D('CourseChapter')->where("course_chapter_course_name = $course_name_id")->delete();
            if ($rst_chapter or $rst_course){
                $this->success('删除成功');
            }else {
                $this->error('删除失败');
            }
        }
    }
    
    /**
     * TODO 删除课程的某一个小节
     * @param number $course_chapter_id
     */
    function deleteCourseChapter($course_chapter_id = 0){
        if ($course_chapter_id){
            //执行删除课程小结操作
            $rst = D('CourseChapter')->where("course_chapter_id = $course_chapter_id")->delete();
            if ($rst){
                $this->success('删除成功');
            }else {
                $this->error('删除失败');
            }
        }
    }
    
    
    
    
    
    
    
    
    
	
}
	