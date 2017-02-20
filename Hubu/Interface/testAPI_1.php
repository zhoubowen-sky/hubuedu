<?php
    header('content-type:text/html;charset=utf-8');//如果这个漏掉了会导致接口无效
    //获取Android上传的字符串
    $text = $_POST['text'];
    
    //获取时间
    $date_tmp = time();//获取Linux时间戳
    $dateline = date("Y-m-d H:i:s", $date_tmp);//将时间戳转换为标准时间
    
    //返回数据
    //echo "1111111111111111111111";
    echo $text.$dateline;