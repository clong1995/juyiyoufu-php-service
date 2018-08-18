<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2018/5/29
 * Time: 17:25
 */

use main\model\impl;
use EasyPhp\util\Util;

switch (ORDER) {
    case 'add'://
        $company = new impl\MenuImpl();
        $res = $company->add(PARAM);
        Util::response($res['state'], $res['data']);
        break;
    case 'delete'://删除公司
        $company = new impl\MenuImpl();
        $res = $company->delete(PARAM['id']);
        Util::response($res['state'], $res['data']);
        break;
    case 'update'://修改公司
        $company = new impl\MenuImpl();
        $res = $company->update(PARAM);
        Util::response($res['state'], $res['data']);
        break;
    case 'getPage':
        $menu = new impl\MenuImpl();
        $res = $menu->getPage((int)PARAM['page']);
        Util::response($res['state'], $res['data']);
        break;
}
