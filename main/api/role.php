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
    case 'relPrivilege'://关联权限
        $role = new impl\RoleImpl();
        $roleId = PARAM['roleId'];
        $privilegeId = PARAM['privilegeId'];
        $res = $role->relPrivilege((int)$roleId, (int)$privilegeId);
        Util::response($res['state'], $res['data']);
        break;
    case 'update':
        $role = new impl\RoleImpl();
        $res =$role->update(PARAM);
        Util::response($res['state'], $res['data']);
        break;
    case 'delPrivilege'://解除关联权限
        $role = new impl\RoleImpl();
        $res =$role->delPrivilege(PARAM);
        Util::response($res['state'], $res['data']);
        break;
}
