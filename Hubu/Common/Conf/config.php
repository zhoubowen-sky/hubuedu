<?php
//config.php是我们当前自己项目的配置文件，我们可以通过修改该文件达到配置变量的目录
//这个文件在系统运行过程中会覆盖convertion.php的配置变量
//此文件配置的信息三个模块都生效

return array(
    'DEFAULT_MODULE'        =>  'Student',  // 默认模块
    'MULTI_MODULE'          =>  true, // 是否允许多模块 如果为false 则必须设置 DEFAULT_MODULE
    
    //以下是发送邮件相关的配置文件
    'THINK_EMAIL' => array(
        'SMTP_HOST' => 'smtp.126.com', //SMTP服务器
        'SMTP_PORT' => '465', //SMTP服务器端口
        'SMTP_USER' => 'hubu_edu_cn@126.com', //SMTP服务器用户名
        'SMTP_PASS' => 'hubueducn123', //SMTP服务器密码，此处填写的是授权码，可以代替密码
        'FROM_EMAIL' => 'hubu_edu_cn@126.com',
        'FROM_NAME' => '湖大在线学习平台', //发件人名称
        'REPLY_EMAIL' => '', //回复EMAIL（留空则为发件人EMAIL）
        'REPLY_NAME' => '', //回复名称（留空则为发件人名称）
        'SESSION_EXPIRE'=>'72',
    ),
    
    
);