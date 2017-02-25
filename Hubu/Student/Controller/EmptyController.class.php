<?php
// 空控制器，用以处理空控制器，以及空操作
namespace Student\Controller;

use Think\Controller;

class EmptyController extends Controller
{
    
    // 空操作的方法
    function _empty()
    {
        echo '服务器繁忙，请稍后再试...';
    }
}