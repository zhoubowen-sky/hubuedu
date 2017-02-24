<?php
// 后台管理首页的控制器
namespace Student\Controller;
use Think\Controller;
class TestController extends Controller {
	
    function index(){
		echo "test" ;
		
	}
	
	function test(){
	    $this->display('test');
	    //test方法
	    //实例化对象
	    $form = D('Test');
	    $aaa = $form->create();//收集表单数据
	    show_bug($aaa);
	    
	    $z = $form->add();//添加数据
	    show_bug($z);
	}
	
	function test2(){
	    $form = D('Test');
	    $aaa = $form->delete(2);
	    show_bug($aaa);
	}
	
	function test3(){
	    $form = D('Test');
	    $aaa = $form->find(3);
	    show_bug($aaa);
	}
	
	function test4(){
	    $this->display('test');
	    $form = M('Test');
	    $aaa = $form->create();//收集表单数据
	    $bbb = $form->where('id=4')->save($aaa);
	    show_bug($bbb);
	}
	
	function test5(){
	    $sql = "SELECT * FROM hubu_feedback";
	    $info = M();
	    $z = $info->query($sql);
	    show_bug($z);
	}
	
	function test6(){
	    header("Content-Type:text/html; charset=utf-8");//设置后不乱码
	    $student_user_id = 1;
	    $User = M("StudentUser"); // 实例化User对象// 更改用户的name值
	    show_bug($User);
	    $z = $User-> where("student_user_id = $student_user_id")->setField('student_user_verify','3');
	    show_bug($z);
	}
	
	function emailCheck(){
	    $a = think_send_mail('1793404975@qq.com','周博文','重要邮件','这不是垃圾邮件啊');
	    show_bug($a);
	    //think_send_mail('要发送的邮箱','发送人名称，即你的名称','邮件主题','邮件内容');
	    
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
    //空操作的方法
    function _empty(){
        echo '服务器繁忙，请稍后再试...';
    }
	
	
	
	
	
	
	
}