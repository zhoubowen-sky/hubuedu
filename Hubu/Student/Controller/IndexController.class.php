<?php
// 后台管理首页的控制器
namespace Student\Controller;
use Think\Controller;
class IndexController extends Controller {
	/**
	 * 展示网站首页的方法，默认调用的方法，index.html也是默认的模版，即首页
	 */
    function index(){
		//echo "这里是学生模块，以后是网站首页" ;
		$this->display('header');
	}
	
	
	
	
}