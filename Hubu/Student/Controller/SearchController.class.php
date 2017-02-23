<?php
// 站内搜索功能的控制器
namespace Student\Controller;
use Think\Controller;
class SearchController extends Controller {
    
    //空操作的方法
    function _empty(){
        echo '服务器繁忙，请稍后再试...';
    }
	
    /**
     * 展示搜索结果的方法
     */
    function search(){
		if (!empty($_POST['search'])){
		    //echo '有提交数据';
		    //show_bug($_POST);
		    $search = $_POST['search'];
		    $wheres = 'course_name_name LIKE \'%'.$search.'%\' OR course_name_intro LIKE \'%'.$search.'%\' OR course_name_adder LIKE \'%'.$search.'%\'';
		    $info = M('CourseName')->where($wheres)->select();
		    
		    if (!empty($info)){
		        //show_bug($info);
		        
		        //替换上述关键字为其他颜色，以示高亮
		        foreach ($info as $k => &$v){
		            //正则表达式替换关键字为红色
		            $v['course_name_name']  = preg_replace('/'.$search.'/','<font color=red>'.$search.'</font>',$v['course_name_name']);
		            $v['course_name_intro'] = preg_replace('/'.$search.'/','<font color=red>'.$search.'</font>',$v['course_name_intro']);
		            $v['course_name_adder'] = preg_replace('/'.$search.'/','<font color=red>'.$search.'</font>',$v['course_name_adder']);
		            //echo $v['course_name_name'];
		        }
		        
		        $this->assign('search_num',count($info));//搜索结果个数
		        $this->assign('search_keywords',$search);
		        $this->assign('search',$info);
		        $this->display();
		        
		    }else {
		        //echo '暂无搜索结果，请更换关键字重新搜索';
		        $this->error('暂无搜索结果，请更换关键字重新搜索');
		    }
		    
		}else {
		    //echo '没有提交数据';
		    $this->redirect(SITE_URL);
		}
	}
	
}