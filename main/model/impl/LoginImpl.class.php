<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-6-26
 * Time: 上午1:28
 */

namespace model\impl;

use model\Login;
use db\impl;
class LoginImpl implements Login
{
    public function pc($phone, $password)
    {
        $company = new impl\CompanyImpl();
        $res = $company->select(['id'],[
            'phone' => $phone,
            'password' => $password
        ]);
        if ($res && count($res) == 1) {//成功
            //写入session、
            session_start();
            $_SESSION['company_id']=$res[0]['id'];
            return 'success';
        } else {//失败
            return 'fail';
        }
    }

}