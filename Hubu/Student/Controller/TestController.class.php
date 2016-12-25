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
	
	
}