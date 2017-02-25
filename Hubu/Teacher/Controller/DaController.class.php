<?php
// 数据分析的控制器
namespace Teacher\Controller;

use Think\Controller;

class DaController extends Controller
{

    /**
     * 展示我所有的课程
     */
    function showMyCourse()
    {
        header("Content-Type:text/html; charset=utf-8"); // 不乱码
        $wheres = 'course_name_adder_id = ' . session('adminuser_id');
        $course_list = M('CourseName')->where($wheres)->select();
        // show_bug($course_list);
        
        // 每门课程的选课人数
        foreach ($course_list as $k => $v) {
            $course_name_id = $v['course_name_id'];
            $course_list[$k]['course_name_choose_count'] = M('ChooseCourse')->where("choose_course_choosed = $course_name_id")->count(); // 已选这门课程总人数
        }
        // show_bug($course_list);
        
        $this->assign('course_list', $course_list);
        $this->display();
    }

    /**
     * 展示选了这门课的学生的列表
     * 
     * @param unknown $course_name_id            
     */
    function showChooseCourseList($course_name_id)
    {
        header("Content-Type:text/html; charset=utf-8"); // 不乱码
        $wheres = 'choose_course_choosed = ' . $course_name_id;
        $student_id_list = M('ChooseCourse')->where($wheres)->select();
        // show_bug($student_id_list);
        
        $student_info_list = array();
        foreach ($student_id_list as $k => $v) {
            
            $student_info_list[$k] = M('StudentUser')->where('student_user_id = ' . $v['choose_course_student'])->find(); // find生成的是一维数组
            
            $chapter_count = D('CourseChapter')->where("course_chapter_course_name = $course_name_id")->count(); // 统计这门课程总节数
            /**
             * 查询出该生该课程的总得学习进度 学习总进度 = 小节进度和/小节数
             */
            $wheres = 'chapter_progress_student = ' . $v['choose_course_student'] . ' and chapter_progress_course = ' . $course_name_id;
            $progress_tmp = M('ChapterProgress')->where($wheres)->sum('chapter_progress_state');
            /**
             * 计算出该生该课程的总学习进度 学习总进度 = 小节进度和/小节数
             */
            $student_info_list[$k]['progress'] = round($progress_tmp / ($chapter_count * 100), 3) * 100; // 算平均评分,四舍五入一位小数,再换算成百分数形式
        }
        // show_bug($student_info_list);
        // krsort($student_info_list);
        
        $student_high_95 = array(); // 全部学完的学生,大于等于95
        $student_low_95 = array();
        $student_low_70 = array(); // 低于80%的学生
        $student_low_50 = array();
        $student_low_30 = array();
        
        foreach ($student_info_list as $kk => $vv) {
            
            if ($vv['progress'] >= 95) {
                $student_high_95[] = $vv;
            } elseif (70 < $vv['progress'] && $vv['progress'] <= 95) {
                $student_low_95[] = $vv;
            } elseif (50 < $vv['progress'] && $vv['progress'] <= 70) {
                $student_low_70[] = $vv;
            } elseif (30 < $vv['progress'] && $vv['progress'] <= 50) {
                $student_low_50[] = $vv;
            } elseif ($vv['progress'] <= 30) {
                $student_low_30[] = $vv;
            } else {}
        } /*
           * show_bug($student_high_95);
           * show_bug($student_low_95);
           * show_bug($student_low_70);
           * show_bug($student_low_50);
           * show_bug($student_low_30);
           */
        
        $this->assign('student_high_95', $student_high_95);
        $this->assign('student_low_95', $student_low_95);
        $this->assign('student_low_70', $student_low_70);
        $this->assign('student_low_50', $student_low_50);
        $this->assign('student_low_30', $student_low_30);
        $this->assign('student_info_list', $student_info_list);
        $this->display();
    }
}