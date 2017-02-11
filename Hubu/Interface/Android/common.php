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

/**
 * 获取一门课程的章节信息
 * @param 课程的ID信息 $course_id
 */
function getCourseSectionChapterList($course_id){
    if (is_numeric($course_id) && $course_id > 0){
        //查询数据库
        try {
            $connect = Db::getInstance()->connect();//mysql连接资源
        } catch (Exception $e){
            // $e->getMessage();//获取错误信息，调试模式使用
            return Response::show(403, '数据库链接失败');
        }

        $sql_section = 'select * from hubu_course_section WHERE course_section_course_name = '.$course_id.' order by course_section_section_num';//查询章信息的SQL语句
        //echo $sql_section;
        $result_section = mysql_query($sql_section, $connect);//查询出章的结果集

        $section = array();//存储章信息的临时数组
        $chapter = array();//存储节信息的临时数组
        $section_chapter = array();//存储章节信息的临时数组

        //循环取出章结果集中的数据
        while($tmp = mysql_fetch_assoc($result_section)) {
            //var_dump($tmp);
            $section[] = $tmp['course_section_name'];//$section是一维数组，专门存储章信息
        }

        //var_dump($section);//exit();

        foreach ($section as $k => $v){
            
            /**下面查询出节的信息并与章信息对号入座*/
            $sql_chapter = 'select * from hubu_course_chapter where course_chapter_course_name = '.$course_id." and course_chapter_section = $k+1  order by course_chapter_section,course_chapter_name";
            $result_chapter = mysql_query($sql_chapter, $connect);//查询出节的结果集
            //var_dump($result_chapter);
            //循环取出节结果集中的数据
            while($tmp2 = mysql_fetch_assoc($result_chapter)) {
                //var_dump($tmp2);
                $chapter[] = $tmp2;
            }
            
            $section_chapter[$k]['chapter_name'] = $v;//章信息
            
            //var_dump($chapter);
            //exit();
            
            //下面代码为更改$chapter里面的字段名称
            $chapter_tmp = array();
            foreach ($chapter as $kk => $vv){
                $chapter_tmp[$kk]['section_id'] = $vv['course_chapter_id'];
                $chapter_tmp[$kk]['name']       = $vv['course_chapter_name'];
                $chapter_tmp[$kk]['video_url']  = ADMIN_IMG_UPLOADS.$vv['course_chapter_video_url'];
                $chapter_tmp[$kk]['ppt_url']    = ADMIN_IMG_UPLOADS.$vv['course_chapter_ppt_url'];
            }
            
            $section_chapter[$k]['section'] = $chapter_tmp;//节信息
            
            $chapter = array();//清空数组，每将一整章所有小节的信息赋值完就必须清空一次
            $chapter_tmp = array();
        }

        //var_dump($section_chapter);

        return $section_chapter;

    }else {
        return 0;
    }
}


