<?php
// 后台管理员 热门课程的控制器,展示课程信息的模板
namespace Admin\Controller;

use Think\Controller;

class HotCourseController extends Controller
{

    /**
     * "热门课程"的模版页面，展示模版页面并向其输出数据
     */
    function hotCourse()
    {
        $hotCourse = D('HotCourse')->getField('hot_course_course_name', true); // 查询出所有课程的ID信息,查询出全部信息
                                                                              // show_bug($hotCourse);
                                                                              // print_r($hotCourse);
                                                                              // 通过上述ID，循环查询出所有课程的信息并存储到数组中
        $hot = array();
        foreach ($hotCourse as $k => $v) {
            // 使用SQL语句查询，或者使用TP自带的CURD方法操作，推荐使用TP的封装方法
            $info = D('CourseName')->where("course_name_id = $v")->find();
            // show_bug($info);
            // 将上述查询到的结果存储到$hot数组里面
            $hot[$k] = $info;
        }
        // show_bug($hot);
        
        /**
         * 查询出所有课程的信息
         * 同时要查询已有的热门课程，如果该课程已经是热门课程，那就不在下面展示出来
         */
        $courseList = D('CourseName')->select();//这里面是所有课程的信息
        //下面剔除已经是热门课程的课程
        //查询出已有的热门课程
        $hotCourseList = D('HotCourse')->select();
        //用循环来剔除热门课程
        //show_bug($courseList);
        $courseListNew = array();
        foreach ($courseList as $k => $v){
            foreach ($hotCourseList as $kk => $vv){
                if ($v['course_name_id'] === $vv['hot_course_course_name']){
                    //$courseListNew[] = $vv['hot_course_course_name'];
                    unset($courseList[$k]);
                }
            }
        }
        //show_bug($courseListNew);
        //show_bug($hotCourseList);
        //show_bug($courseList);
        $this->assign('courseList', $courseList);
        
        $this->assign('hot', $hot);
        $this->display();
    }

    /**
     * 删除指定的热门课程
     * 
     * @param number $hot_course_id            
     */
    function deleteHotCourse($hot_course_id = 0)
    {
        if ($hot_course_id) {
            $info = D('HotCourse')->where("hot_course_course_name = $hot_course_id")->delete(); // 执行删除操作
            if ($info) {
                $this->success('删除热门课程成功');
            } else {
                $this->error('删除热门课程失败');
            }
        } else {
            $this->error('出现未知错误！');
        }
    }

    /**
     * 添加一门课程为热门课程
     */
    function addHotCourse()
    {
        if (! empty($_POST)) {
            // show_bug($_POST);
            $info = D('HotCourse')->create();//收集表单数据，是课程的ID值
            // show_bug($info);
            $z = D('HotCourse')->add($info); // 添加热门课程到数据库中
            if ($z) {
                $this->success('添加成功');
            } else {
                $this->error('添加失败');
            }
        }
    }
}