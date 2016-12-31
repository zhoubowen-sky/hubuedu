<?php
//学生用户个人基本信息Model
namespace Model;
use Think\Model;

//父类是Model 
class StudentUserModel extends Model{
    //可以自定义数据表的相关属性，例如数据表前缀，名称等等，进行个性化的设置
    
    
    /**
     * 功能：验证用户名以及密码  供控制器使用
     * @param 登陆表单中用户输入的用户名/邮箱 $name
     * @param 登陆表单中用户输入的密码 $pwd
     * @return boolean|unknown
     */
    function checkNamePwd($name,$pwd){
        //根据$name查询数据库里面是否有这一条记录
        //可以根据指定字段进行查询getByXXX($name)，XXX是字段名，Model父类封装好的方法，执行结果一位数组，PHP本身不区分大小写，采用驼峰法命名
        //此处驼峰法命名与数据库之间有一个下划线_的关系,AdminUser对应数据表名字hubu_admin_user,hubu_为数据表前缀
        $info = $this-> getBystudent_user_email($name);
        //show_bug($info);//$info是一个以为数组才是正确，为空说明表单用户名输入错误
        //$info不为空，继续验证密码
        if($info != null){
            //验证密码,查询出来儿密码对比用户输入的密码
            if($info['student_user_pwd'] != $pwd){
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
    
    
    
    /**
     * 更新学生用户的账户激活状态
     * @param 传入的id的值 $student_user_id
     */
    function activeAccount_Model($student_user_id=0){
        header("Content-Type:text/html; charset=utf-8");//设置后不乱码
        
        //直接使用SQL语句来更新数据，建议少使用SQL语句，容易加大SQL注入的风险，尽量用框架提供的方法来做
        //$sql = "UPDATE hubu_student_user SET student_user_verify = 1 WHERE student_user_id = $student_user_id";
        //$a = $this->execute($sql);
        
        $User = M("StudentUser"); // 实例化对象
        $b = $User-> where("student_user_id = $student_user_id")->setField('student_user_verify',1);
        //show_bug($b);
        return $b;
    }
    
    
    
    
    
    
}