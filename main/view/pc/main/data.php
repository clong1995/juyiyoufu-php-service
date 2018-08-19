<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-8-20
 * Time: 上午1:15
 */

declare(strict_types=1);

use \EasyPhp\util\Util;

$menu = Util::getSession('menu');

//向前段输出的首屏数据
Util::JSData(['menu'=>$menu]);