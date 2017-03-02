<?php
// 后台管理首页的控制器
namespace Admin\Controller;

use Think\Controller;

class RecommendedController extends Controller
{
    
    // 空操作的方法
    function _empty()
    {
        echo '服务器繁忙，请稍后再试...';
    }
    
    /**
     * 管理员对后台精品课程进行查看修改的的方法
     */
    function updateRecommendedCourse(){
        echo '这是updateRecommendedCourse';
        $courseList = M('Recommended')->order('recommended_class')->select();//按照类别ID从小到大排序查询
        //show_bug($courseList);
    }

}