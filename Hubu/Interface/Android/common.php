<?php
/**
 * 此文件用以存储所需的例如常量，公共函数等的代码
 */

//自己定义的CSS JS IMG路径全局常量，用以存储网页相关的资源文件的路径
//定义路径常量，直接定义http绝对路径，框架在应用的时候会自动将SITE_URL 与 CSS等资源路径进行组合得到一个统一资源定位符
define("SITE_URL", "http://120.27.104.19:3002/");//站点路径
define("ADMIN_ROOT_URL", SITE_URL."Hubu/Public/");//资源根路径
define("ADMIN_CSS_URL", SITE_URL."Hubu/Public/css/");//css路径
define("ADMIN_JS_URL", SITE_URL."Hubu/Public/js/");//js路径
define("ADMIN_IMG_URL", SITE_URL."Hubu/Public/images/");//images图片路径
define("ADMIN_IE_URL", SITE_URL."Hubu/Public/ie/");//适配ie9以下浏览器的js文件
//为上传用户头像路径设置路径
define("ADMIN_IMG_UPLOADS", SITE_URL."Hubu/Public/");
//定义用户头像默认存储位置
define("ADMIN_DEFAULT_IMG", "Uploads/default/default_admin_user.jpg");

/**
 * 获取一门课程的选课人数
 * @param number $course_name_id
 * @return string|number
 */
function getChoosedCount($course_name_id = 0){
    if ($course_name_id){
        
        //接收异常，数据库连接失败
        try {
            $connect = Db::getInstance()->connect();//mysql连接资源
        } catch (Exception $e){
            // $e->getMessage();//获取错误信息，调试模式使用
            return Response::show(403, '数据库链接失败');
        }
        
        //从数据库中查询出这门课程的选课人数
        $sql = 'select * from hubu_choose_course where choose_course_choosed = '.$course_name_id;
        $result = mysql_query($sql, $connect);//结果集
        return mysql_num_rows($result);
        
    }else {
        return 0;
    }
}

/**
 * 获取一门课程的小节总数
 * @param number $course_name_id
 * @return string|number
 */
function getChapterCount($course_name_id = 0){
    if ($course_name_id){
        //查询数据库
        
        //接收异常，数据库连接失败
        try {
            $connect = Db::getInstance()->connect();//mysql连接资源
        } catch (Exception $e){
            // $e->getMessage();//获取错误信息，调试模式使用
            return Response::show(403, '数据库链接失败');
        }
        
        //从数据库中查询出这门课程的小节总数
        $sql = 'select * from hubu_course_chapter where course_chapter_course_name = '.$course_name_id;
        $result = mysql_query($sql, $connect);//结果集
        return mysql_num_rows($result);
        
    }else {
        return 0;
    }
}

/**
 * 根据hot_course数据表里面的ID信息查询出该课程的所有信息
 * @param number $course_id
 */
function getHotCourse($course_id = 0){
    
    if ($course_id){
        //连接数据库
        //接收异常，数据库连接失败
        try {
            $connect = Db::getInstance()->connect();//mysql连接资源
        } catch (Exception $e){
            // $e->getMessage();//获取错误信息，调试模式使用
            return Response::show(403, '数据库链接失败');
        }
        
        $hot_course_list_tmp = array();//存储热门课程的临时数组
        
        $sql = 'select * from hubu_course_name where course_name_id = '.$course_id;
        $result = mysql_query($sql, $connect);//查询出结果集
        //循环取出结果集中的数据
        while($course_name = mysql_fetch_assoc($result)) {
            //var_dump($course_name);
            $hot_course_list_tmp[] = $course_name;
        }
        //var_dump($hot_course_list_tmp);
        if ($hot_course_list_tmp){
            return $hot_course_list_tmp['0'];//只返回一维数组
        }else {
            return 0;
        }
    
    }else {
        return 0;
    }
}
