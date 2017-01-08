<?php
// 后台管理首页的控制器
namespace Student\Controller;
use Think\Controller;
class IndexController extends Controller {
	/**
	 * 展示网站首页的方法，默认调用的方法，index.html也是默认的模版，即首页
	 */
    function index(){
        header("Content-Type:text/html; charset=utf-8");//首页不乱码
		//echo "这里是学生模块，以后是网站首页" ;
		$this->display('index');
	}
	
	/**
	 * 展示bottom的模板，这个需要复用
	 * 原本Index也要做出复用的，但是已经写成现在这样了，就不改了
	 */
	function bottom(){
	    header("Content-Type:text/html; charset=utf-8");//首页不乱码
	    //echo "bottom" ;
	    $this->display();
	}
	
	function header(){
	    $this->display();
	}
	
	
}