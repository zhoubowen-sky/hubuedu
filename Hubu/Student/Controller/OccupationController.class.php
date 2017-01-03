<?php
// 课程的控制器,展示课程信息的模板
namespace Student\Controller;
use Think\Controller;
class OccupationController extends Controller {
    /**
     * "职业"选项的网页模板展示，与IndexController同等级别
     */
    function index(){
        //echo "这是职业展示页面";
        $this->display();
    }
	
	
	
}