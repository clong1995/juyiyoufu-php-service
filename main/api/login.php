<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2018/5/29
 * Time: 17:25
 */

use model\impl;
switch (ORDER) {
    case 'weixin'://添加
        $data = request('https://api.weixin.qq.com/sns/jscode2session',[
            'method'=>'GET',
            'data'=>[
                'appid'=>'wx25c3dff3ae7fa3b9',
                'secret'=>'648ad685334d349c14ab97e472113be5',
                'js_code'=>PARAM['code'],
                'grant_type'=>'authorization_code'
            ]
        ]);
        response('success',$data);
        break;

    case 'pc'://添加
        $login = new impl\LoginImpl();
        $res = $login->pc(PARAM['phone'],PARAM['password']);
        if($res == 'success'){
            response('success',$res);
        }else{
            response('fail',$res);
        }
        break;
}
