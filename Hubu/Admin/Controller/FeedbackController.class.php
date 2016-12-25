<?php
// 后台管理用户留言的控制器
namespace Admin\Controller;
use Think\Controller;
class FeedbackController extends Controller {
	
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
		$feedback = D('Feedback');
		$info = $feedback->select();//从数据库中查询出数据存储在$info中
		//show_bug($info);
		$this->assign('info',$info);
		$this->display();
	}
	
	function find1(){
	    $info = D('Feedback');
	    $z = $info->find(1);
	    show_bug($z);
	}
	
	
}