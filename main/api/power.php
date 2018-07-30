<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2018/5/29
 * Time: 17:25
 */

declare(strict_types=1);

use EasyPhp\util\Util;
use main\model\impl;

switch (ORDER) {
    case 'add'://添加
        $power = new impl\PowerImpl();
        $res = $power->add(PARAM);
        Util::response($res['state'], $res['data']);
        break;

    case 'update'://更新
        $power = new impl\PowerImpl();
        $res = $power->update(PARAM);
        Util::response($res['state'], $res['data']);
        break;

    case 'delById'://删除
        $power = new impl\PowerImpl();
        $res = $power->delById((int)PARAM['id']);
        Util::response($res['state'], $res['data']);
        break;
    case 'getPage':
        $power = new impl\PowerImpl();
        $res = $power->getPage((int)PARAM['page'], 10);
        Util::response($res['state'], $res['data']);
        break;
}
