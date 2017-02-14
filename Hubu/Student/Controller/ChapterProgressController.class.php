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
     * 接收前端传过来的用户小节视频播放进度记录
     * @param 数据表这条数据的ID $id
     * @param 学生用户的ID $student_id
     * @param 课程ID值 $course_id
     * @param 章节ID值 $chapter_id
     * @param 状态记录，60%记录为60 $state
     */
    function receiveChapterProgress($id ,$student_id ,$course_id ,$chapter_id ,$state){
        
    }
    
    
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
    
    
    
    
    
    
	
}