<?php
// 用户学习进度业务逻辑处理的控制器
namespace Student\Controller;
use Think\Controller;
class ChapterProgressController extends Controller {

    function test(){
        $info = D('ChapterProgress')->select();
        show_bug($info);
    }
    
    
    
    /**
     * 获取用户某一课程所有小节的学习进度
     * @param 课程ID $course_id
     * @param 学生用户ID $student_id
     * @return array
     */
    function getChapterProgress($course_id ,$student_id){
        
        $progress = D('ChapterProgress')->where('chapter_progress_student = '.$student_id.' and chapter_progress_course = '.$course_id)->select();
        //show_bug($progress);
        $progress_chapter = array();
        foreach ($progress as $k => $v){
            $progress_chapter[$v['chapter_progress_chapter']] = $v['chapter_progress_state'];
        }
        //show_bug($progress_chapter);
        return $progress_chapter;
    }
    /**
     * 接收前台Ajax传来的用户视频播放进度数据
     * 并将数据存储到数据库中
     */
    function receiveChapterProgress(){
        //if (IS_POST){
            $student_id       = $_POST['student_id'];
            $course_id        = $_POST['course_id'];
            $chapter_id       = $_POST['chapter_id'];
            $chapter_progress = $_POST['chapter_progress'];
            $chapter_nowprogress = round($_POST['chapter_nowprogress'],2);//四舍五入保留两位小时
            $wheres = 'chapter_progress_student = '.$student_id.' and chapter_progress_course = '.$course_id.' and chapter_progress_chapter = '.$chapter_id;
            $info = M('ChapterProgress')->where($wheres)->find();
            //show_bug($info);
            if (!empty($info)){
                //原来数据库中有这条记录，则更新这条记录即可
                if ($info['chapter_progress_state'] < 100){
                    //echo '小于100';
                    $chapter_progress1    = $chapter_progress + $info['chapter_progress_state'];//百分比累加
                    if ($chapter_progress1 >= 100){
                        $chapter_progress1 = 100;
                        $chapter_nowprogress = 0;//时间归零
                    }else {
                        //不进行操作
                    }
                    $arr = array(
                        'chapter_progress_state' => $chapter_progress1,
                        'chapter_progress_current_time' => $chapter_nowprogress,
                    );
                    //更新数据库
                    //show_bug($arr);
                    $rst = M('ChapterProgress')->where('chapter_progress_id = '.$info['chapter_progress_id'])->save($arr);
                    //show_bug($rst);
                    if ($rst){
                        $this->ajaxReturn(json_encode('data-save-success'.$chapter_progress.'A'.$chapter_nowprogress));
                    }else {
                        $this->ajaxReturn(json_encode('data-save-fail'.$chapter_progress));
                    }
                    
                }elseif ($info['chapter_progress_state'] >= 100){
                    //什么也不做，不操作数据库
                    $this->ajaxReturn(json_encode('data-is-100%'.$chapter_progress));
                }
                
            }else {
                //原来数据库中没有这条数据，插入一条新的记录
                $arr = array(
                    'chapter_progress_state'   => $chapter_progress,
                    'chapter_progress_student' => $student_id,
                    'chapter_progress_course'  => $course_id,
                    'chapter_progress_chapter' => $chapter_id,
                    'chapter_progress_current_time' => $chapter_nowprogress,
                    'chapter_progress_time'    => date('y-m-d h:i:s',time())
                );
                $rst = M('ChapterProgress')->add($arr);
                //show_bug($rst);
                if ($rst){
                    $this->ajaxReturn(json_encode('data-save-success'.$chapter_progress));
                }else {
                    $this->ajaxReturn(json_encode('data-save-fail'.$chapter_progress));
                }
            }
        //}
    }
    
    
    
    
	
}