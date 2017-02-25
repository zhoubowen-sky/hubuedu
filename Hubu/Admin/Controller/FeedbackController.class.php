<?php
// 后台管理用户留言的控制器
namespace Admin\Controller;

use Think\Controller;

class FeedbackController extends Controller
{

    function feedback($feedback_id = 0)
    {
        // echo $feedback_id;
        // 获取“删除”按钮传回来的id，根据id来执行删除
        if ($feedback_id > 0) {
            // 执行删除操作
            $del = D('Feedback');
            $rst = $del->delete($feedback_id);
            // show_bug($rst);
        }
        
        // 用户留言的浏览与管理页面
        // echo "feedback";
        // var_dump(get)
        // 从数据库中查询出数据，并输出到前台模板
        $m = M('Feedback');
        $where = '';
        $p = getpage($m, $where, 6);
        $list = $m->field(true)
            ->where($where)
            ->select();
        $this->list = $list;
        $this->page = $p->show();
        $this->assign('info', $list);
        
        // $feedback = D('Feedback');
        // $info = $feedback->select();//从数据库中查询出数据存储在$info中
        // show_bug($info);
        // $this->assign('info',$info);
        $this->display();
    }

    function emailCheck()
    {
        $a = think_send_mail('zhoubowen.sky@foxmail.com', '发件人', '在线学习平台', '这是一封测试邮件，无需回复！不要太在意为什么是126邮箱。。。这并不重要。。。');
        show_bug($a);
        // think_send_mail('要发送的邮箱','发送人名称，即你的名称','邮件主题','邮件内容');
    }
}