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
            $this->assign('course_name',$course_name);
            $this->display();
        }
    }
	
    function feedback($feedback_id = 0){
        //echo $feedback_id;
        //获取“删除”按钮传回来的id，根据id来执行删除
        if($feedback_id > 0){
            //执行删除操作
            $del = D('Feedback');
            $rst = $del->delete($feedback_id);
            //show_bug($rst);
        }
        
        //用户留言的浏览与管理页面
		//echo "feedback";
		//var_dump(get)
		//从数据库中查询出数据，并输出到前台模板
        $m = M('Feedback');
        $where = '';
        $p = getpage($m,$where,6);
        $list = $m->field(true)->where($where)->select();
        $this->list = $list;
        $this->page = $p->show();
        $this->assign('info',$list);
        
		//$feedback = D('Feedback');
		//$info = $feedback->select();//从数据库中查询出数据存储在$info中
		//show_bug($info);
		//$this->assign('info',$info);
		$this->display();
	}
	
	
	
}