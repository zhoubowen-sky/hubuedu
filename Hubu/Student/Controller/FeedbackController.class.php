<?php
// 后台管理首页的控制器
namespace Student\Controller;

use Think\Controller;

class FeedbackController extends Controller
{
    
    // 空操作的方法
    function _empty()
    {
        echo '服务器繁忙，请稍后再试...';
    }

    /**
     * *
     * 处理用户反馈表单的方法
     */
    function feedback()
    {
        // echo "feedback";
        // show_bug(empty($_POST));
        // 判断用户是否提交了表单
        if (! empty($_POST)) {
            // 用户提交了表单
            // echo "有表单数据";
            // 收集表单数据
            // show_bug($_POST);
            // 把时间添加到$_POST里面
            $_POST['feedback_time'] = date("Y-m-d H:i:s");
            $info = D('Feedback');
            $z = $info->create();
            // show_bug(count($z));
            $a = $info->add(); // 将表单数据存储到数据库
                               // show_bug($a);//这里$a是插入后那一行数据的ID号
                               // 下面的这个判断并没有多大用，留给前端去实现表单验证吧
            if ($a) {
                // 数据提交存储成功,链接跳转
                $this->success('我们已收到您的反馈，会及时处理！');
            } else {
                // 数据存储失败
                $this->error('反馈提交失败，请重新提交！');
            }
        } else {
            // 用户没有提交表单，直接展示模版
            // echo "无表单数据";
            $this->display();
        }
    }
}