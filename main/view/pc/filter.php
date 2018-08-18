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

