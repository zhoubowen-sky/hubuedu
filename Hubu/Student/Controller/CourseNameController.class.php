<?php
// 课程名称的控制器,展示所有课程信息
namespace Student\Controller;

use Think\Controller;

class CourseNameController extends Controller
{
    
    // 空操作的方法
    function _empty()
    {
        echo '服务器繁忙，请稍后再试...';
    }

    /**
     * 从数据库中获取所有的课程名称，并输出到模板
     * 对应的数据表为hubu_course_name
     */
    function getCourseName()
    {
        $info = D('CourseName');
        // show_bug($info);
        $course_name = $info->select(); // 获取数据库中的全部数据
                                        // show_bug($course_name);
        $this->assign('course_name', $course_name);
        // $this->display('course_name');
    }

    /**
     * *****说实在话，写下面这么多一模一样的方法实在没必要，可以只写一个方法，使用switch case 设置传入的参数不同，从而调用不同的指令,但我还是挨个写一遍吧******
     */
    
    /**
     * 所有的课程
     */
    function all()
    {
        $m = M('CourseName');
        $where = ''; // 查询条件为空，即查询出所有的课程
        $p = getpage($m, $where, 5);
        $list = $m->field(true)
            ->where($where)
            ->select();
        $this->list = $list;
        $this->page = $p->show();
        
        /**
         * 循环查询出每门课程的选课人数以及总节数
         */
        foreach ($list as $k => $v) {
            $course_name_id = $v['course_name_id'];
            $list[$k]['course_choosed_count'] = M('ChooseCourse')->where("choose_course_choosed = $course_name_id")->count(); // 已选这门课程总人数
            $list[$k]['course_chapter_count'] = D('CourseChapter')->where("course_chapter_course_name = $course_name_id")->count(); // 统计这门课程总节数
        }
        // show_bug($list);
        $this->assign('course_name', $list);
        $this->display('course_name');
    }

    /**
     * 计算机类课程
     */
    function computer()
    {
        $m = M('CourseName');
        $where = 'course_name_class = 1'; // 课程类别信息在hubu_course_class里面有定义，之所以不在字段中字节定义是因为int型数据查询更快，而这个地方是查询最多的项
        $p = getpage($m, $where, 5);
        $list = $m->field(true)
            ->where($where)
            ->select();
        $this->list = $list;
        $this->page = $p->show();
        /**
         * 循环查询出每门课程的选课人数以及总节数
         */
        foreach ($list as $k => $v) {
            $course_name_id = $v['course_name_id'];
            $list[$k]['course_choosed_count'] = M('ChooseCourse')->where("choose_course_choosed = $course_name_id")->count(); // 已选这门课程总人数
            $list[$k]['course_chapter_count'] = D('CourseChapter')->where("course_chapter_course_name = $course_name_id")->count(); // 统计这门课程总节数
        }
        $this->assign('course_name', $list);
        $this->display('course_name');
    }

    /**
     * 经济管理
     */
    function ecoManagement()
    {
        $m = M('CourseName');
        $where = 'course_name_class = 2';
        $p = getpage($m, $where, 5);
        $list = $m->field(true)
            ->where($where)
            ->select();
        $this->list = $list;
        $this->page = $p->show();
        /**
         * 循环查询出每门课程的选课人数以及总节数
         */
        foreach ($list as $k => $v) {
            $course_name_id = $v['course_name_id'];
            $list[$k]['course_choosed_count'] = M('ChooseCourse')->where("choose_course_choosed = $course_name_id")->count(); // 已选这门课程总人数
            $list[$k]['course_chapter_count'] = D('CourseChapter')->where("course_chapter_course_name = $course_name_id")->count(); // 统计这门课程总节数
        }
        $this->assign('course_name', $list);
        $this->display('course_name');
    }

    /**
     * 心理学
     */
    function psychology()
    {
        $m = M('CourseName');
        $where = 'course_name_class = 3';
        $p = getpage($m, $where, 5);
        $list = $m->field(true)
            ->where($where)
            ->select();
        $this->list = $list;
        $this->page = $p->show();
        /**
         * 循环查询出每门课程的选课人数以及总节数
         */
        foreach ($list as $k => $v) {
            $course_name_id = $v['course_name_id'];
            $list[$k]['course_choosed_count'] = M('ChooseCourse')->where("choose_course_choosed = $course_name_id")->count(); // 已选这门课程总人数
            $list[$k]['course_chapter_count'] = D('CourseChapter')->where("course_chapter_course_name = $course_name_id")->count(); // 统计这门课程总节数
        }
        $this->assign('course_name', $list);
        $this->display('course_name');
    }

    /**
     * 外语
     */
    function foreignLanguage()
    {
        $m = M('CourseName');
        $where = 'course_name_class = 4';
        $p = getpage($m, $where, 5);
        $list = $m->field(true)
            ->where($where)
            ->select();
        $this->list = $list;
        $this->page = $p->show();
        /**
         * 循环查询出每门课程的选课人数以及总节数
         */
        foreach ($list as $k => $v) {
            $course_name_id = $v['course_name_id'];
            $list[$k]['course_choosed_count'] = M('ChooseCourse')->where("choose_course_choosed = $course_name_id")->count(); // 已选这门课程总人数
            $list[$k]['course_chapter_count'] = D('CourseChapter')->where("course_chapter_course_name = $course_name_id")->count(); // 统计这门课程总节数
        }
        $this->assign('course_name', $list);
        $this->display('course_name');
    }

    /**
     * 文学历史
     */
    function literaryHistory()
    {
        $m = M('CourseName');
        $where = 'course_name_class = 5';
        $p = getpage($m, $where, 5);
        $list = $m->field(true)
            ->where($where)
            ->select();
        $this->list = $list;
        $this->page = $p->show();
        /**
         * 循环查询出每门课程的选课人数以及总节数
         */
        foreach ($list as $k => $v) {
            $course_name_id = $v['course_name_id'];
            $list[$k]['course_choosed_count'] = M('ChooseCourse')->where("choose_course_choosed = $course_name_id")->count(); // 已选这门课程总人数
            $list[$k]['course_chapter_count'] = D('CourseChapter')->where("course_chapter_course_name = $course_name_id")->count(); // 统计这门课程总节数
        }
        $this->assign('course_name', $list);
        $this->display('course_name');
    }

    /**
     * 艺术设计
     */
    function artDesign()
    {
        $m = M('CourseName');
        $where = 'course_name_class = 6';
        $p = getpage($m, $where, 5);
        $list = $m->field(true)
            ->where($where)
            ->select();
        $this->list = $list;
        $this->page = $p->show();
        /**
         * 循环查询出每门课程的选课人数以及总节数
         */
        foreach ($list as $k => $v) {
            $course_name_id = $v['course_name_id'];
            $list[$k]['course_choosed_count'] = M('ChooseCourse')->where("choose_course_choosed = $course_name_id")->count(); // 已选这门课程总人数
            $list[$k]['course_chapter_count'] = D('CourseChapter')->where("course_chapter_course_name = $course_name_id")->count(); // 统计这门课程总节数
        }
        $this->assign('course_name', $list);
        $this->display('course_name');
    }

    /**
     * 工学
     */
    function engineering()
    {
        $m = M('CourseName');
        $where = 'course_name_class = 7';
        $p = getpage($m, $where, 5);
        $list = $m->field(true)
            ->where($where)
            ->select();
        $this->list = $list;
        $this->page = $p->show();
        /**
         * 循环查询出每门课程的选课人数以及总节数
         */
        foreach ($list as $k => $v) {
            $course_name_id = $v['course_name_id'];
            $list[$k]['course_choosed_count'] = M('ChooseCourse')->where("choose_course_choosed = $course_name_id")->count(); // 已选这门课程总人数
            $list[$k]['course_chapter_count'] = D('CourseChapter')->where("course_chapter_course_name = $course_name_id")->count(); // 统计这门课程总节数
        }
        $this->assign('course_name', $list);
        $this->display('course_name');
    }

    /**
     * 理学
     */
    function science()
    {
        $m = M('CourseName');
        $where = 'course_name_class = 8';
        $p = getpage($m, $where, 5);
        $list = $m->field(true)
            ->where($where)
            ->select();
        $this->list = $list;
        $this->page = $p->show();
        /**
         * 循环查询出每门课程的选课人数以及总节数
         */
        foreach ($list as $k => $v) {
            $course_name_id = $v['course_name_id'];
            $list[$k]['course_choosed_count'] = M('ChooseCourse')->where("choose_course_choosed = $course_name_id")->count(); // 已选这门课程总人数
            $list[$k]['course_chapter_count'] = D('CourseChapter')->where("course_chapter_course_name = $course_name_id")->count(); // 统计这门课程总节数
        }
        $this->assign('course_name', $list);
        $this->display('course_name');
    }

    /**
     * 生命科学
     */
    function biomedicine()
    {
        $m = M('CourseName');
        $where = 'course_name_class = 9';
        $p = getpage($m, $where, 5);
        $list = $m->field(true)
            ->where($where)
            ->select();
        $this->list = $list;
        $this->page = $p->show();
        /**
         * 循环查询出每门课程的选课人数以及总节数
         */
        foreach ($list as $k => $v) {
            $course_name_id = $v['course_name_id'];
            $list[$k]['course_choosed_count'] = M('ChooseCourse')->where("choose_course_choosed = $course_name_id")->count(); // 已选这门课程总人数
            $list[$k]['course_chapter_count'] = D('CourseChapter')->where("course_chapter_course_name = $course_name_id")->count(); // 统计这门课程总节数
        }
        $this->assign('course_name', $list);
        $this->display('course_name');
    }

    /**
     * 哲学
     */
    function philosophy()
    {
        $m = M('CourseName');
        $where = 'course_name_class = 10';
        $p = getpage($m, $where, 5);
        $list = $m->field(true)
            ->where($where)
            ->select();
        $this->list = $list;
        $this->page = $p->show();
        /**
         * 循环查询出每门课程的选课人数以及总节数
         */
        foreach ($list as $k => $v) {
            $course_name_id = $v['course_name_id'];
            $list[$k]['course_choosed_count'] = M('ChooseCourse')->where("choose_course_choosed = $course_name_id")->count(); // 已选这门课程总人数
            $list[$k]['course_chapter_count'] = D('CourseChapter')->where("course_chapter_course_name = $course_name_id")->count(); // 统计这门课程总节数
        }
        $this->assign('course_name', $list);
        $this->display('course_name');
    }

    /**
     * 法学
     */
    function law()
    {
        $m = M('CourseName');
        $where = 'course_name_class = 11';
        $p = getpage($m, $where, 5);
        $list = $m->field(true)
            ->where($where)
            ->select();
        $this->list = $list;
        $this->page = $p->show();
        /**
         * 循环查询出每门课程的选课人数以及总节数
         */
        foreach ($list as $k => $v) {
            $course_name_id = $v['course_name_id'];
            $list[$k]['course_choosed_count'] = M('ChooseCourse')->where("choose_course_choosed = $course_name_id")->count(); // 已选这门课程总人数
            $list[$k]['course_chapter_count'] = D('CourseChapter')->where("course_chapter_course_name = $course_name_id")->count(); // 统计这门课程总节数
        }
        $this->assign('course_name', $list);
        $this->display('course_name');
    }

    /**
     * 教育教学
     */
    function teachingMethod()
    {
        $m = M('CourseName');
        $where = 'course_name_class = 12';
        $p = getpage($m, $where, 5);
        $list = $m->field(true)
            ->where($where)
            ->select();
        $this->list = $list;
        $this->page = $p->show();
        /**
         * 循环查询出每门课程的选课人数以及总节数
         */
        foreach ($list as $k => $v) {
            $course_name_id = $v['course_name_id'];
            $list[$k]['course_choosed_count'] = M('ChooseCourse')->where("choose_course_choosed = $course_name_id")->count(); // 已选这门课程总人数
            $list[$k]['course_chapter_count'] = D('CourseChapter')->where("course_chapter_course_name = $course_name_id")->count(); // 统计这门课程总节数
        }
        $this->assign('course_name', $list);
        $this->display('course_name');
    }

    /**
     * 其他
     */
    function elseCourse()
    {
        $m = M('CourseName');
        $where = 'course_name_class = 13';
        $p = getpage($m, $where, 5);
        $list = $m->field(true)
            ->where($where)
            ->select();
        $this->list = $list;
        $this->page = $p->show();
        /**
         * 循环查询出每门课程的选课人数以及总节数
         */
        foreach ($list as $k => $v) {
            $course_name_id = $v['course_name_id'];
            $list[$k]['course_choosed_count'] = M('ChooseCourse')->where("choose_course_choosed = $course_name_id")->count(); // 已选这门课程总人数
            $list[$k]['course_chapter_count'] = D('CourseChapter')->where("course_chapter_course_name = $course_name_id")->count(); // 统计这门课程总节数
        }
        $this->assign('course_name', $list);
        $this->display('course_name');
    }
}