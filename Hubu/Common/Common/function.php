<?php
/**
 * 发送邮件的方法
 * @param 收信人邮箱 $to
 * @param 发信人名称 $name
 * @param 邮件主题 $subject
 * @param 邮件内容 $body
 * @param string $attachment
 * @return boolean
 */
function think_send_mail($to, $name, $subject = '', $body = '', $attachment = null){
    $config = C('THINK_EMAIL');
    vendor('PHPMailer.class#phpmailer'); //从PHPMailer目录导class.phpmailer.php类文件
    vendor('SMTP');
    $mail = new PHPMailer(); //PHPMailer对象
    $mail->CharSet = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->IsSMTP(); // 设定使用SMTP服务
    $mail->SMTPDebug = 0; // SMTP调试功能
    // 1 = errors and messages
    // 2 = messages only
    // 0 关闭
    $mail->SMTPAuth = true; // 启用 SMTP 验证功能
    $mail->SMTPSecure = 'ssl'; // 使用安全协议
    $mail->Host = $config['SMTP_HOST']; // SMTP 服务器
    $mail->Port = $config['SMTP_PORT']; // SMTP服务器的端口号
    $mail->Username = $config['SMTP_USER']; // SMTP服务器用户名
    $mail->Password = $config['SMTP_PASS']; // SMTP服务器密码
    $mail->SetFrom($config['FROM_EMAIL'], $config['FROM_NAME']);
    $replyEmail = $config['REPLY_EMAIL']?$config['REPLY_EMAIL']:$config['FROM_EMAIL'];
    $replyName = $config['REPLY_NAME']?$config['REPLY_NAME']:$config['FROM_NAME'];
    $mail->AddReplyTo($replyEmail, $replyName);
    $mail->Subject = $subject;
    $mail->AltBody = "为了查看该邮件，请切换到支持 HTML 的邮件客户端";
    $mail->MsgHTML($body);
    $mail->AddAddress($to, $name);
    if(is_array($attachment)){ // 添加附件
        foreach ($attachment as $file){
            is_file($file) && $mail->AddAttachment($file);
        }
    }
    return $mail->Send() ? true : $mail->ErrorInfo;

}


/**
 * TODO 基础分页的相同代码封装，使前台的代码更少
 * @param $m 模型，引用传递
 * @param $where 查询条件
 * @param int $pagesize 每页查询条数
 * @return \Think\Page
 */
function getPage(&$m,$where,$pagesize=10){
    $m1=clone $m;//浅复制一个模型
    $count = $m->where($where)->count();//连惯操作后会对join等操作进行重置
    $m=$m1;//为保持在为定的连惯操作，浅复制一个模型
    $p=new Think\Page($count,$pagesize);
    $p->lastSuffix=false;
    $p->setConfig('header','<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
    $p->setConfig('prev','上一页');
    $p->setConfig('next','下一页');
    $p->setConfig('last','末页');
    $p->setConfig('first','首页');
    $p->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

    $p->parameter=I('get.');

    $m->limit($p->firstRow,$p->listRows);

    return $p;
}



/**
 * 用以生成符合输出课程章节列表数组的方法，从数据库获取指定数据并生成对应格式返回
 * @param 课程章表里面对应的课程名$course_section_course_name字段的值  $course_section_course_name
 * @param 课程节表里面对应的课程名$course_chapter_course_name字段的值  $course_chapter_course_name
 * @return Ambigous <multitype:, \Think\mixed, Arrary数组>
 */
function getCourseSectionChapterList($course_section_course_name,$course_chapter_course_name){
    /**这里section代表章，例如第一章，chapter代表节，例如1-1节*/
    $info_chapter = D('CourseChapter');//实例化CourseChapter 好获取数据表hubu_course_chapter中的数据
    $info_section = M('CourseSection');//实例化Model
     
    $sql_section = "select * from hubu_course_section WHERE course_section_course_name = $course_section_course_name";//选出该课程的所有章信息
    $rst_section = $info_section->query($sql_section);//章信息存储在$rst_section里面
     
    //$sql_chapter = "select * from hubu_course_chapter where course_chapter_course_name = $course_chapter_course_name and course_chapter_section = $course_chapter_section";//查询出该课程所有节信息
    //$rst_chapter = $info_chapter->query($sql_chapter);//节信息存储在$rst_section里面
     
    /**将上述 $rst_chapter 以及  $rst_section 信息合并成我们所需要的数据格式*/
    $res = array();//存储最终结果的数组
    foreach ($rst_section as $key => $value){
        $res[$value['course_section_name']][] = $value['course_section_name'];

        //获取新的$rst
        $sql = "select * from hubu_course_chapter where course_chapter_course_name = 1 and course_chapter_section = $key+1";//查询出该课程所有章节
        $rst = $info_chapter->query($sql);

        foreach ($rst as $k => $v){
            $res[$value['course_section_name']][$k] = $v;
        }
    }
    //show_bug($res);
    //所需要的数组格式如下
    /* $test_arr = array(
        '第一章hahaha'=>array(
            array(
                'course_chapter_name'=>'1.0前言',
                'course_chapter_time'=>'2017-01-20 19:25:16'),
            array(
                'course_chapter_name'=>'1.1前言',
                'course_chapter_time'=>'2017-01-20 19:25:16'),
            array(
                'course_chapter_name'=>'1.2前言',
                'course_chapter_time'=>'2017-01-20 19:25:16')
        ),
        '第二章,,,,,'=>array(
            array(
                'course_chapter_name'=>'2.0前言',
                'course_chapter_time'=>'2017-01-20 19:25:16'),
            array(
                'course_chapter_name'=>'2.1前言',
                'course_chapter_time'=>'2017-01-20 19:25:16'),
            array(
                'course_chapter_name'=>'2.2前言',
                'course_chapter_time'=>'2017-01-20 19:25:16'
            )
        ),
        '第三章nnn'=>array(
            array(
                'course_chapter_name'=>'3.0前言',
                'course_chapter_time'=>'2017-01-20 19:25:16'),
            array(
                'course_chapter_name'=>'3.1前言',
                'course_chapter_time'=>'2017-01-20 19:25:16'),
            array(
                'course_chapter_name'=>'3.2前言',
                'course_chapter_time'=>'2017-01-20 19:25:16'
            )
        )
    ); */
    return $res;
}
