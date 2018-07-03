<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2018/5/29
 * Time: 17:25
 */

use model\impl;
switch (ORDER) {
    case 'pc'://添加
        $signIn = new impl\SignInImpl();
        $res = $signIn->pc(PARAM['phone'],PARAM['password']);
        if($res == 'success'){
            response('success',$res);
        }else{
            response('fail',$res);
        }
        break;
}
