<?php
// 前台首页图片轮播的控制器
namespace Teacher\Controller;
use Think\Controller;
use Model\ImgTurnModel;
class ImgTurnController extends Controller {
    /**
     * TODO 展示首页轮播图的信息，并且实现新数据的添加
     */
    function showImgTurnInfo(){
        if(empty($_POST)){
            //用户没有提交表单，展示首页轮播图信息
            //echo "用户没有提交表单";
            header("Content-type:text/html;charset=utf-8");//不乱码
            //调用下面获取数据的方法，从数据库中崇训处所有的数据
            $info = A('ImgTurn')->getImgTurnInfo();
            //show_bug($info);
            $this->assign('info',$info);
            $this->display('adv');
        }else {
            //echo "用户有提交表单";
            //检测是否有附件上传
            //show_bug($_FILES);
            if(!empty($_FILES)){
                //echo "有附件上传";
                //自定义文件接收相关配置
                $config = array(
                    'rootPath'      =>  'Hubu/Public/', //保存根路径,Andim目录下面public目录定义为Admin的根目录，这里的路径设置是以admin.php所在路径为依据设置
                    'savePath'      =>  'Uploads/', //保存路径为Uploads，TP框架会自动生成如2016-12-18的日期文件夹
                );
                //print_r($_FILES);//是个二维数组
                $upload = new \Think\Upload($config);//实例化Upload对象
                //show_bug($upload);
                $z = $upload->uploadOne($_FILES['pic']);//执行上传操作
                //print_r($z);
                //show_bug($z);
                if (!$z){
                    $this->error($upload->getError());//输出错误
                } else {
                    //$this->success("文件上传成功！");
                    echo "头像文件上传成功！";
                }
            }
            $_POST['img_turn_pic_url'] = $z['savepath'].$z['savename'];/**这里存储用户头像的文件路径*/
            $_POST['img_turn_time'] = date('Y-m-d H:i:s');
            $imgTurnInfo = D('ImgTurn')->create();//收集表单数据,create不能收集文件数据，所以要单独添加到$_POST里面
            //show_bug($imgTurnInfo);
            //将数据存储到数据库里面
            $rst = D('ImgTurn')->add($imgTurnInfo);//如果添加成功返回的是这条记录的ID
            //show_bug($rst);
            if ($rst){
                $this->success('数据添加成功！');
            }else {
                $this->error('数据添加失败！');
            }
        }
        
    }
    
    /**
     * TODO 获取数据表hubu_img_turn里面的所有数据 ，其实按道理，数据的操作都应该放在Model里面来写
     * @return \Think\mixed
     */
    function getImgTurnInfo(){
        $info = D('ImgTurn')->select();//从数据库中选出所有轮播图片的信息
        //show_bug($info);
        //返回获取到的信息
        return $info;
    }
    
    /**
     * TODO 修改某一条轮播图记录,其实他的实现代码与上述添加是一样的，，忘了写成公共函数了，这里就再复制一次吧
     * @param 选中的这条记录的ID值  $img_turn_id
     */
    function updateImgTurnInfo($img_turn_id){
        //echo $img_turn_id;
        //判断是否有表单提交
        if(empty($_POST)){
            //没有表单提交
            //echo "没有表单提交";
            $info = D('ImgTurn')->select($img_turn_id);
            //show_bug($info);
            $this->assign('info',$info);
            $this->display('update_adv');
        }else {
            //有表单数据提交
            //echo "有表单提交";
            //判断是否有文件提交
        if(!empty($_FILES)){
                //echo "有附件上传";
                //自定义文件接收相关配置
                $config = array(
                    'rootPath'      =>  'Hubu/Public/', //保存根路径,Andim目录下面public目录定义为Admin的根目录，这里的路径设置是以admin.php所在路径为依据设置
                    'savePath'      =>  'Uploads/', //保存路径为Uploads，TP框架会自动生成如2016-12-18的日期文件夹
                );
                //print_r($_FILES);//是个二维数组
                $upload = new \Think\Upload($config);//实例化Upload对象
                //show_bug($upload);
                $z = $upload->uploadOne($_FILES['pic']);//执行上传操作
                //print_r($z);
                //show_bug($z);
                if (!$z){
                    $this->error($upload->getError());//输出错误
                } else {
                    //$this->success("文件上传成功！");
                    echo "头像文件上传成功！";
                }
            }
            $_POST['img_turn_pic_url'] = $z['savepath'].$z['savename'];/**这里存储用户头像的文件路径*/
            $_POST['img_turn_time'] = date('Y-m-d H:i:s');
            $imgTurnInfo = D('ImgTurn')->create();//收集表单数据,create不能收集文件数据，所以要单独添加到$_POST里面
            //show_bug($imgTurnInfo);
            $id = $_POST['img_turn_id'];
            //echo "ID为".$id;
            //将数据存储到数据库里面
            $rst = D('ImgTurn')->where("img_turn_id = $id")->save($imgTurnInfo);//如果添加成功返回的是这条记录的ID
            //show_bug($rst);
            if ($rst){
                $this->success('数据添加成功！');
            }else {
                $this->error('数据添加失败！');
            }
        }
        
    }
    
    /**
     * TODO 删除指定的轮播图
     * @param 要删除的轮播图在数据库里面的id $img_turn_id
     */
    function deleteImgTurnTnfo($img_turn_id = 0){
        if($img_turn_id){
            $rst = D('ImgTurn')->delete($img_turn_id);
            //show_bug($rst);
            $this->redirect('Teacher/ImgTurn/showImgTurnInfo');
        }else {
            $this->error('删除错误！');
        }
    }

    
    function test(){
        $info = D('ImgTurn');
        //show_bug($info);
        
    }
	
	
}