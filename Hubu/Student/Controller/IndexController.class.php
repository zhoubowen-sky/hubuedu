<?php
// 后台管理首页的控制器
namespace Student\Controller;
use Think\Controller;
class IndexController extends Controller {
	
    function index(){
		//echo "这里是学生模块，以后是网站首页" ;
		$this->display('header');
	}
	
	
}