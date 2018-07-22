<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2018/5/29
 * Time: 17:25
 */

use model\impl;

switch (ORDER) {
    case 'add'://增加公司
        $company = new impl\CompanyImpl();
        $res = $company->add(PARAM);
        response($res['state'], $res['data']);
        break;
    case 'delete'://删除公司
        $company = new impl\CompanyImpl();
        $res = $company->delete(PARAM['id']);
        response($res['state'], $res['data']);
        break;
    case 'update'://修改公司
        $company = new impl\CompanyImpl();
        $res = $company->update(PARAM);
        response($res['state'], $res['data']);
        break;
}
