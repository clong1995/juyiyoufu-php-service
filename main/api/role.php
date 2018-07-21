<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2018/5/29
 * Time: 17:25
 */

use model\impl;

switch (ORDER) {
    case 'relPrivilege'://关联权限
        $role = new impl\RoleImpl();
        $roleId = PARAM['roleId'];
        $privilegeId = PARAM['privilegeId'];
        $res = $role->relPrivilege($roleId,$privilegeId);
        response($res['state'], $res['data']);
        break;
}
