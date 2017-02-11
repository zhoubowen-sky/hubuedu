<?php
//接口URL地址：http://120.27.104.19:3002/Hubu/Interface/Android/student_login.php?format=json

/**
 * 学生用户登录的接口，验证用户密码是否正确，生成session，向客户端回传用户的个人信息
 */

require_once 'response.php';    //引入公共文件
require_once 'db.php';          //数据库连接文件
require_once 'common.php';

$_POST['userinfo'] = '{"username":"1784225410@qq.com","password":"123456"}';

if (!empty($_POST)){
    
    //接收异常，数据库连接失败
    try {
        $connect = Db::getInstance()->connect();//mysql连接资源
    } catch (Exception $e){
        // $e->getMessage();//获取错误信息，调试模式使用
        return Response::show(403, '数据库链接失败');
    }
    
    //接收POST数据
    $str = $_POST['userinfo'];
    //判断是否为JSON格式
    if(is_null(json_decode($str))){
        return Response::show(421, '学生用户登录API使用错误，post上传的数据不是标准的JSON格式');
        exit();
    }
    
    $userinfo_obj = json_decode($str,true);//解析JSON数据
    
    if (empty($userinfo_obj['username'])){
        //echo 'username不存在';
        return Response::show(419, '学生用户登录API使用错误，里面不含有 username 字段');
        exit();
    }elseif (empty($userinfo_obj['password'])){
        return Response::show(420, '学生用户登录API使用错误，里面不含有 password 字段');
        exit();
    }
    
    $username = $userinfo_obj['username'];
    $password = $userinfo_obj['password'];
    
    //验证账户密码是否正确

    $sql = 'select * from hubu_student_user where student_user_email = '.'\''.$username.'\'';//不能漏掉了引号
    //echo $sql;
    $result = mysql_query($sql, $connect);//查询出的结果集
    //var_dump($result);
    
    $userinfo = array();
    while ($tmp = mysql_fetch_assoc($result)){
        $userinfo[] = $tmp;
    }
    
    if (empty($userinfo)){
        return Response::show(414, '用户名不存在');
        exit();
    }else {
        //判断账号是否处于激活状态
        if ($userinfo[0]['student_user_verify'] == '1'){
            //用户账户已经激活,验证密码是否正确
            if ($password == $userinfo[0]['student_user_pwd']){
                //密码正确，生成session，回传用户信息,回传用户已选的课程
                //var_dump($userinfo);
                
                $i = array();//存储用户个人信息的数组 hubu_student_user里面的数据
                foreach ($userinfo as $k => $v){
                    $i['email']    = $v['student_user_email'];
                    $i['username'] = $v['student_user_username'];
                    $i['sex']      = $v['student_user_sex'];
                    $i['tel']      = $v['student_user_tel'];
                    $i['qq']       = $v['student_user_qq'];
                    $i['addr']     = $v['student_user_addr'];
                    $i['pic']      = ADMIN_IMG_UPLOADS.$v['student_user_pic'];
                    $i['intro']    = $v['student_user_intro'];
                    $i['verify']   = $v['student_user_verify'];
                    
                    //生成session
                    $_SESSION['student_user_email'] = $v['student_user_email'];
                    $_SESSION['student_user_id']    = $v['student_user_id'];
                }
                //var_dump($i);
                
                
                $sql_mycourse = 'select * from hubu_choose_course where choose_course_student = '.$userinfo[0]['student_user_id'];//已选课程
                $result_mycourse = mysql_query($sql_mycourse, $connect);
                $mycourse = array();
                while ($mycourse_tmp = mysql_fetch_assoc($result_mycourse)){
                    $mycourse[] = $mycourse_tmp['choose_course_choosed'];//获取已选课程的ID信息
                    //$mycourse[] = $mycourse_tmp;
                }
                //var_dump($mycourse);
                if (empty($mycourse)){
                    //用户一门课也没有选
                    $arr = array(
                        'userinfo' => $i,
                        'mycourse' => ''
                    );
                    return Response::show(417, '登陆成功，用户没有已选的课程',$arr);
                    exit();
                }else {
                    //用户有已选的课程
                    $arr = array(
                        'userinfo' => $i,
                        'mycourse' => $mycourse
                    );
                    return Response::show(418, '登陆成功，学生用户个人信息以及已选课程的ID信息获取成功',$arr);
                    exit();
                }
            }else {
                //密码输入错误
                return Response::show(416, '密码输入不正确');
            }
        }else {
            //账户未激活
            return Response::show(415, '账户处于未激活状态');
        }
    }
}else {
    //提交的是空表单
    return Response::show(413,'提交的表单为空');
}
