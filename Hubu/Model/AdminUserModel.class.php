<?php

//User数据模型Model,数据库中的每个数据表都对应一个model模型文件

namespace Model;
use Think\Model;

//父类是Model 
class AdminUserModel extends Model{
    //可以自定义数据表的相关属性，例如数据表前缀，名称等等，进行个性化的设置
    /**
     * 功能：验证用户名以及密码  供AdminUser控制器使用
     * @param 登陆表单中用户输入的用户名 $name
     * @param 登陆表单中用户输入的密码 $pwd
     * @return boolean|unknown
     */
    function checkNamePwd($name,$pwd){
        //根据$name查询数据库里面是否有这一条记录
        //可以根据指定字段进行查询getByXXX($name)，XXX是字段名，Model父类封装好的方法，执行结果一位数组，PHP本身不区分大小写，采用驼峰法命名
        //此处驼峰法命名与数据库之间有一个下划线_的关系,AdminUser对应数据表名字hubu_admin_user,hubu_为数据表前缀
        $info = $this-> getByAdminuser_email($name);
        //show_bug($info);//$info是一个以为数组才是正确，为空说明表单用户名输入错误
        //$info不为空，继续验证密码
        if($info != null){
            //验证密码,查询出来儿密码对比用户输入的密码
            if($info['adminuser_pwd'] != $pwd){
                return false;//返回false
            } else {
                //密码输入正确
                return $info;//返回$info，回头生成session信息
            }
        } else {
            //密码错误
            return false;//返回false
        }
    }
}