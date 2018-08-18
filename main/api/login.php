<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2018/5/29
 * Time: 17:25
 */

use EasyPhp\util\Util;
use main\model\impl;

switch (ORDER) {
    case 'weixin'://微信登录
        $data = Util::request('https://api.weixin.qq.com/sns/jscode2session', [
            'method' => 'GET',
            'data' => [
                'appid' => 'wx25c3dff3ae7fa3b9',
                'secret' => '648ad685334d349c14ab97e472113be5',
                'js_code' => PARAM['code'],
                'grant_type' => 'authorization_code'
            ]
        ]);
        Util::response('success', $data);
        break;

    case 'pc'://pc登录
        $login = new impl\LoginImpl();
        $res = $login->pc(PARAM['phone'], PARAM['password']);
        Util::response($res);
        break;
}
