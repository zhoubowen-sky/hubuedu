<?php
//学生用户个人基本信息的控制器
namespace Student\Controller;
use Think\Controller;
class StudentUserController extends Controller {
    
    /**
	 * 用户登录的方法，
	 * 接收用户输入的表单数据（账户，密码，验证码），
	 * 并对其进行校验，生成session
	 */
	function login(){
	    //判断用户是否提交了表单
	    if(!empty($_POST)){
	        //提交了表单
	        //print_r($_POST);
	        //验证码校验，实例化一个Verify对象,调用其中的check方法校验验证码
	        $verify = new \Think\Verify();
	        if(!$verify ->check($_POST['code'])){
	            //echo "验证码错误！";
	            $this->error("验证码输入错误！");
	        } else {
	            //验证码输入正确，账号密码校验
	            $user = new \Model\StudentUserModel();//实例化StudentUserModel调用其中的checkNamePwd()方法,好对student_user数据库中的数据进行操作
	            $z = $user->checkNamePwd($_POST['student_user_email'], $_POST['student_user_pwd']);
	            //show_bug($z);
	            //判断账号密码是否验证成功
	            if($z === false){
	                //账号密码输入错误
	                $this->error("输入的用户名或密码错误!");
	            }else {
	                //账号密码输入正确
	                //进行账号激活校验，即student_user_verify字段，只有此字段为真（1）才能进行下一步操作，否则发送邮件激活
	                $rst = $user->getField('student_user_verify');
	                //show_bug($rst);
	                if (!$rst){
	                    //邮箱没有验证,提示发送邮件验证
	                    $email = $user->getField('student_user_email');//获取邮箱字段的值
	                    $id = $user->getField('student_user_id');//获取id
	                    //发送激活邮件
	                    //show_bug($email);
	                    //账号激活的URL地址,例如  http://web.hubu.edu:3002/index.php/Student/StudentUser/activeAccount/id/1
	                    $activeURL = SITE_URL.'index.php/Student/StudentUser/activeAccount/id/'.$id.' ';
	                    //show_bug($activeURL);
	                    $a = think_send_mail($email,'湖北大学网络课程平台','账号激活邮件','您的账号为：'.$email.',点击链接激活账号：'.$activeURL);
	                    $this->error("您的账号还没有激活，我们已向您的邮箱 $email 发送了激活邮件，请注意查收！");
	                }else {
	                    /*****登陆成功后执行的操作****/
	                    echo "登陆成功";
	                    
	                }
	            }
	        }
	    }
	}
	
	/**
	 * 用以激活学生用户的账号
	 * 用户点击这个链接后实现对数据库中student_user_verify字段的更改，将其值改为1
	 * @param 要传入的学生用户那一天记录的id值 $id
	 */
	function activeAccount($id=0){
	    if($id){
	        //echo $id;
	        //传入的id值大于0，即不是默认值，对student_user数据表中字段进行修改
	        $user = new \Model\StudentUserModel();//实例化StudentUser,调用其中的方法来操作数据库，注意，数据库的操作尽量都留在Model里面
	        $z = $user->activeAccount_Model($id);
	        //show_bug($z);
	        if($z){
	            //echo "^_^恭喜你，账号激活成功！点击链接访问：".SITE_URL;
	            $this->success('^_^恭喜你，账号激活成功！',SITE_URL);
	        }
	        
	    }else {
	        //echo "额。。。貌似出现了什么了不得的东西，账号激活失败，请联系网站管理员！";
	        $this->error('额，账号激活失败。貌似出现了什么了不得的东西，请联系网站管理员！',SITE_URL);
	    }
	    
	}
	
	/**
	 * 用户个人中心
	 * 展示个人基本信息，提供基本信息的修改功能
	 */
	function personalCenter(){
	    $this->display();
	}
	
	/**
	 * 学生用户注册的方法
	 * 接收注册时候的表单，并向数据库写入注册用户信息
	 */
	function register(){
	    
	}
	
	/**
	 * 名称：verifyImg()
	 * 功能：实现验证发的生成
	 */
	function verifyImg(){
	    //配置验证码的数组
	    $config = array(
	        'expire'    =>  1800,            // 验证码过期时间（s）
	        'useZh'     =>  false,           // 使用中文验证码
	        'useImgBg'  =>  false,           // 使用背景图片
	        'fontSize'  =>  14,              // 验证码字体大小(px)
	        'useCurve'  =>  false,            // 是否画混淆曲线
	        'useNoise'  =>  false,            // 是否添加杂点
	        'imageH'    =>  32,               // 验证码图片高度
	        'imageW'    =>  100,               // 验证码图片宽度
	        'length'    =>  4,               // 验证码位数
	        'fontttf'   =>  '',              // 验证码字体，不设置随机获取
	        'bg'        =>  array(243, 251, 254),  // 背景颜色
	        'reset'     =>  true,           // 验证成功后是否重置
	    );
	    //实例化的时候传入配置
	    $verify = new \Think\Verify($config); //实例化Verify对象，此处要注意命名空间的书写，可以使用在admin.php中定义的show_bug()函数输出对象看实例化好了没有
	    //show_bug($verify);
	    $verify ->entry();
	}
    
    //下面的方法作为书写login的参考
	/***
	 * 处理用户反馈表单的方法
	 */
    function feedback(){
		//echo "feedback";
		//show_bug(empty($_POST));
		//判断用户是否提交了表单
		if (!empty($_POST)){
		    //用户提交了表单
		    //echo "有表单数据";
		    //收集表单数据
		    //show_bug($_POST);
		    //把时间添加到$_POST里面
		    $_POST['feedback_time'] = date("Y-m-d H:i:s");
		    $info = D('Feedback');
    		$z = $info->create();
    		//show_bug(count($z)); 
    		$a = $info->add();//将表单数据存储到数据库
    		//show_bug($a);//这里$a是插入后那一行数据的ID号
    		//下面的这个判断并没有多大用，留给前端去实现表单验证吧
    		if($a){
    		    //数据提交存储成功,链接跳转
    		    $this->success('我们已收到您的反馈，会及时处理！');
    		}else {
    		    //数据存储失败
    		    $this->error('反馈提交失败，请重新提交！');
    		}
		}else {
		    //用户没有提交表单，直接展示模版
		    //echo "无表单数据";
		    $this->display();
		}
		
	}
	
	
}