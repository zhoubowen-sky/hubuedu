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
	
	function emailCheck(){
	    $a = think_send_mail('zhoubowen.sky@foxmail.com','发件人名称填写处','湖大在线学习平台','这是一封测试邮件，无需回复！不要太在意为什么是126邮箱。。。这并不重要。。。');
	    show_bug($a);
	    //think_send_mail('要发送的邮箱','发送人名称，即你的名称','邮件主题','邮件内容');
	    
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}