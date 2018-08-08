<?php

declare(strict_types=1);

use EasyPhp\util\Util;
use main\model\impl;

switch (ORDER) {
    case 'city'://添加
        $regional = new impl\RegionalImpl();
        $res = $regional->city((int)PARAM['id']);
        Util::response($res['state'], $res['data']);
        break;
    case 'area'://添加
        $regional = new impl\RegionalImpl();
        $res = $regional->area((int)PARAM['id']);
        Util::response($res['state'], $res['data']);
        break;
}