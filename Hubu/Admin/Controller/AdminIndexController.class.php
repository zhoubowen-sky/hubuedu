<?php
// 后台管理首页的控制器
namespace Admin\Controller;
use Think\Controller;
class AdminIndexController extends Controller {
    /**
     * 用以展示后台管理首页的模板
     */
    function index(){
		//下面是用来输出所有常量的语句
		//var_dump(get_defined_constants(true));
        //调用视图display()，直接展示index.html模板，display()没有参数那么调用的模板名称就与当前方法名一致
        $this->display();
	}
	
	/**
	 * 展示管理员基本信息的模板
	 */
	function userinfo() {
	    $this->display();
	}


	
}