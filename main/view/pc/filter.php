<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-24
 * Time: 上午2:16
 */

use EasyPhp\util\Util;

//请求头限制
$head = getallheaders();
if ($head['Host'] !== 'pc.nurse.juyiyoufu.com')
    exit('The application of the illegal deployment！');

//客户端限制
if (strpos($head['User-Agent'], 'Electron') === false)
    Util::notFound('Illegal client!');

//检查登录和权限
if ($routeArr[1] != 'login') {//不是login
    //检查注册的id
    if (!Util::getSession('user_id')) {
        Util::notFound('Not logged in!');
    }
    //判断权限
    if (!in_array($route, Util::getSession('privilege')))
        Util::notFound('No permission to use!');
}
