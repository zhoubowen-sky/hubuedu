<?php
// 后台管理首页的控制器
namespace Student\Controller;
use Think\Controller;
class RecommendedController extends Controller {

    /**
     * 精品推荐的相关课程
     */
    function recommended(){
        header("Content-Type:text/html; charset=utf-8");//不乱码
        $info = M('Recommended')->select();
        //show_bug($info);
        
        $recommended = array();//存储模板需要的数据，下面的代码将生成所需格式的数据
        foreach ($info as $k => $v){
            $course_name_id = $v['recommended_course_name'];
            $course_info = D('CourseName')->where("course_name_id = $course_name_id")->find();
            //show_bug($course_info);
            $course_info['course_name_choosed_num'] = M('ChooseCourse')->where("choose_course_choosed = $course_name_id")->count();//已选这门课程总人数
            $recommended[$k] = $course_info;
        }
        //show_bug($recommended);
        
        $this->assign('recommended',$recommended);//向模板输出数据
        $this->display();
    }
    
	
}