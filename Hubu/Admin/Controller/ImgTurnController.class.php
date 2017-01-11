<?php
// 前台首页图片轮播的控制器
namespace Admin\Controller;
use Think\Controller;
class ImgTurnController extends Controller {
    /**
     * 其实按道理，数据的操作都应该放在Model里面来写
     * @return \Think\mixed
     */
    function getImgTurnInfo(){
        $info = D('ImgTurn')->select();//从数据库中选出所有轮播图片的信息
        //show_bug($info);
        //返回获取到的信息
        return $info;
    }
    
    function updateImgTurnInfo(){
        
    }
    
    function deleteImgTurnTnfo(){
        
    }

    
    function test(){
        $info = D('ImgTurn');
        //show_bug($info);
        show_bug(A('ImgTurn')->getImgTurnInfo());
    }
	
	
}