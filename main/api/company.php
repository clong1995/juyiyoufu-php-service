<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2018/5/29
 * Time: 17:25
 */

use model\impl;

switch (ORDER) {
    case 'add'://关联权限
        $company = new impl\CompanyImpl();
        $res = $company->add(PARAM);
        response($res['state'], $res['data']);
        break;
}
