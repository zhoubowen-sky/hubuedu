<?php

// 后台管理员用户控制器
// 命名空间必须写在第一行
namespace Admin\Controller;

use Think\Controller;

class AdminUserController extends Controller
{

    /**
     * 名称：login()
     * 功能：管理员用户登录的相关逻辑判断
     */
    function login()
    {
        // 判断用户是否提交了表单
        if (! empty($_POST)) {
            // 先输出这个值看对不对,经输出，得输出值为 Array ( [name] => 00 [password] => 000 [code] => 000 )
            // print_r($_POST);
            // 验证码校验
            $verify = new \Think\Verify(); // 实例化一个Verify对象，好调用其中的校验验证码的方法 check($code, $id)
            if (! $verify->check($_POST['code'])) {
                // echo "验证码错误！";
                $this->error("验证码输入错误！");
            } else {
                // echo "验证码正确！";
                // 验证码正确之后，判断用户名和密码
                // 可以直接用一条SQL语句从数据库中同时查询用户名和密码，如果存在就说明正确，但此方法不安全，会增加SQL注入风险
                // 一般，先查询指定用户名的信息，如果有这条信息再比较密码是否正确
                // 在model模型里面专门写一个方法进行验证，当前model模型为AdminUserModel，不要再控制器里面验证
                $user = new \Model\AdminUserModel(); // 实例化AdminUserModel()对象，好调用其中自定义的检验用户名密码是否正确的方法checkNamePwd($name,$pwd)
                
                $rst = $user->checkNamePwd($_POST['username'], $_POST['password']);
                // $rst如果为false，那说明输入的密码不正确，如果为一个数组，就说明输入正确，就可以生成session信息
                // show_bug($rst);
                if ($rst === false) {
                    // echo "输入的用户名或者密码错误!";
                    $this->error("输入的用户名或密码错误!");
                } else {
                    // 登录信息持久化，生成session信息
                    // 性别在数据库中存储为1,2两种形式，如果为数字1就是男，数字2就是女，这里写一个判断
                    if ($rst['adminuser_sex'] == 1) {
                        session('adminuser_sex', '男'); // 存储用户性别adminuser_sex
                    } else 
                        if ($rst['adminuser_sex'] == 2) {
                            session('adminuser_sex', '女'); // 存储用户性别adminuser_sex
                        } else {
                            session('adminuser_sex', '未知'); // 存储用户性别adminuser_sex
                        }
                    session('adminuser_id', $rst['adminuser_id']); // 存储id
                    session('adminuser_username', $rst['adminuser_username']); // 存储用户名adminuser_username
                    session('adminuser_email', $rst['adminuser_email']); // 存储用户adminuser_email
                                                                                 // session('adminuser_sex', $rst['adminuser_sex']);//存储用户性别adminuser_sex
                    session('adminuser_tel', $rst['adminuser_tel']); // 存储用户电话adminuser_tel
                    session('adminuser_qq', $rst['adminuser_qq']); // 存储用户QQ adminuser_qq
                    session('adminuser_addr', $rst['adminuser_addr']); // 存储用户地址adminuser_addr
                    session('adminuser_introduction', $rst['adminuser_introduction']); // 存储用户个人简介adminuser_introduction
                    session('adminuser_pic', $rst['adminuser_pic']); // 存储用户头像路径信息
                                                                               // echo "登陆成功！";
                                                                               // 跳转到后台首页,Controller类的redirect()方法 $this->redirect('New/category', array('cate_id' => 2), 5, '页面跳转中...');
                                                                               // 将参数array('cate_id' => 2)传递到index
                    $this->redirect('AdminIndex/index'/*,array('adminuser_username' => $rst['adminuser_username']) ,1,'正在登录到后台系统...' */);
                }
            }
        } else {
            // 调用视图display()，直接展示login.html模板，display()没有参数那么调用的模板名称就与当前方法名一致
            $this->display();
        }
    }

    /**
     * 名称：logout() 退出系统的方法
     * 功能：要清除session，跳转到登录页面
     */
    function logout()
    {
        session(null); // 清除所有的session值
        $this->redirect('AdminUser/login'); // 跳转到登录界面，即调用AdminUser控制器的login方法
    }

    /**
     * 名称：verifyImg()
     * 功能：实现验证发的生成
     */
    function verifyImg()
    {
        // 配置验证码的数组
        $config = array(
            'expire' => 1800, // 验证码过期时间（s）
            'useZh' => false, // 使用中文验证码
            'useImgBg' => false, // 使用背景图片
            'fontSize' => 14, // 验证码字体大小(px)
            'useCurve' => false, // 是否画混淆曲线
            'useNoise' => false, // 是否添加杂点
            'imageH' => 32, // 验证码图片高度
            'imageW' => 100, // 验证码图片宽度
            'length' => 4, // 验证码位数
            'fontttf' => '', // 验证码字体，不设置随机获取
            'bg' => array(
                243,
                251,
                254
            ), // 背景颜色
            'reset' => true
        ) // 验证成功后是否重置
;
        // 实例化的时候传入配置
        $verify = new \Think\Verify($config); // 实例化Verify对象，此处要注意命名空间的书写，可以使用在admin.php中定义的show_bug()函数输出对象看实例化好了没有
                                              // show_bug($verify);
        $verify->entry();
    }

    /**
     * 实现用户注册的方法
     */
    public function register()
    {
        echo "这是用户注册功能，待完善中...";
    }

    /**
     * 实现对自己管理员账户信息的修改操作
     * 接收表单提交过来的数据
     * 并将数据库中的用户个人信息进行更新
     */
    function updateUserInfo()
    {
        // print_r($_POST);//Array ( [mpass] => 123456 [newpass] => 234567 [renewpass] => 234567 )
        // echo count($_POST);//输出数组长度，后面根据数组长度判断提交的是哪个表单
        
        // 1.检测用户是否提交了表单
        if (! empty($_POST)) {
            
            // print_r($_POST);
            // 检测用户提交的是哪个表单，根据$_POST数组长度来判断
            if (count($_POST) == 3) {
                // 用户提交的是修改管理员密码的表单
                // 需要验证用户名与密码是否正确，可以直接跨控制器调用AdminUser/checkNamwePwd方法
                $info = new \Model\AdminUserModel();
                // show_bug($info);
                $rst = $info->checkNamePwd(session('adminuser_username'), $_POST['mpass']); // 从session中获取当前用户的用户名
                                                                                            // show_bug($rst);
                                                                                            // echo session('adminuser_username');
                if ($rst) {
                    // 原始密码输入正确
                    // echo "原始密码输入正确";
                    // 1.收集表单数据 2.实现用户密码的修改操作
                    $arr = array(
                        'adminuser_pwd' => $_POST['renewpass'],/* 获取表单中的新密码 */
	                );
                    $resault = $info->where('adminuser_id = %d', array(
                        session('adminuser_id')
                    ))->save($arr);
                    // show_bug($resault);
                    // 根据$resault值判断是否修改成功，给予用户提示信息
                    if ($resault) {
                        // 修改成功
                        // echo "修改密码成功";
                        // 跳转到原页面
                        $this->redirect('AdminUser/updateUserInfo', array(), 3, '密码修改成功...正在跳转...');
                    } else {
                        // 修改不成功
                        // echo "修改不成功";
                        $this->redirect('AdminUser/updateUserInfo', array(), 3, '密码修改失败/未更改...正在跳转...');
                    }
                } else {
                    // 原始密码输入不正确
                    // echo "原始密码输入不正确";
                    $this->redirect('AdminUser/updateUserInfo', array(), 3, '原始密码输入不正确...正在跳转...');
                }
            } else {
                // 用户提交的是修改管理员其他信息的表单
                // echo "用户提交的是修改管理员其他信息的表单";
                // $aaaa = D('AdminUser');
                // $a = $aaaa->select();
                // show_bug($a);
                $info = new \Model\AdminUserModel();
                // 判断是否有附件上传，有就实例化Upload，把附件上传到服务器指定位置，获得附件路径名存入$_POST
                if (! empty($_FILES)) {
                    // 自定义文件接收相关配置
                    $config = array(
                        'rootPath' => 'Hubu/Public/', // 保存根路径,Andim目录下面public目录定义为Admin的根目录，这里的路径设置是以admin.php所在路径为依据设置
                        'savePath' => 'Uploads/'
                    ) // 保存路径为Uploads，TP框架会自动生成如2016-12-18的日期文件夹
;
                    // print_r($_FILES);//是个二维数组
                    $upload = new \Think\Upload($config); // 实例化Upload对象
                                                          // show_bug($upload);
                    $z = $upload->uploadOne($_FILES['pic']); // 执行上传操作
                                                             // print_r($z);
                                                             // show_bug($z);
                    if (! $z) {
                        $this->error($upload->getError()); // 输出错误
                    } else {
                        // $this->success("文件上传成功！");
                        echo "头像文件上传成功！";
                    }
                }
                
                // 实现对用户其他信息修改的操作
                // 收集post表单数据
                $user_info = array(
                    'adminuser_email' => $_POST['email'],
                    'adminuser_sex' => $_POST['sex'],
                    'adminuser_tel' => $_POST['tel'],
                    'adminuser_qq' => $_POST['qq'],
                    'adminuser_addr' => $_POST['addr'],
                    'adminuser_introduction' => $_POST['introduction'],
                    'adminuser_pic' => /* $config['rootPath']. */$z['savepath'] . $z['savename']
                )/**
                 * 这里存储用户头像的文件路径
                 */
                ;
                // show_bug($user_info);
                $res = $info->where('adminuser_id = %s', array(
                    $_POST['adminuser_id']
                ))->save($user_info);
                // show_bug($res);
                // 根据$resault值判断是否修改成功，给予用户提示信息
                if ($res) {
                    // 修改成功
                    // echo "修改成功";
                    /**
                     * 因为页面上部分信息是从session中获得，所以更改个人信息后就需要更新以下session
                     */
                    // 跳转到原页面
                    $this->redirect('AdminUser/updateUserInfo', array(), 3, '信息修改成功，重新登录后生效...正在跳转...');
                } else {
                    // 修改不成功
                    // echo "信息修改不成功";
                    $this->redirect('AdminUser/updateUserInfo', array(), 3, '信息修改失败/未更改...正在跳转...');
                }
            }
        } else {
            // 用户没有提交表单，那么从session中读取出用户的个人信息，放到表单里面
            // 展现表单
            
            // $this->assign($a);
            $this->display();
        }
        // echo "实现对自己管理员账户信息的修改操作";
        // $this->display();
    }
}