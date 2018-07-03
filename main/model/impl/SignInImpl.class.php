<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-6-24
 * Time: 上午7:42
 */

//include DIR.'main/model/SignIn.class.php';

namespace model\impl;

use model\SignIn;
use db\impl;

class SignInImpl implements SignIn
{
    public function pc($phone, $password)
    {
        $company = new impl\CompanyImpl();
        $res = $company->insert([[
            'phone' => $phone,
            'password' => $password
        ]]);

        if ($res) {//成功
            //写入session
            session_start();
            $_SESSION['company_id']=$res['id'];
            return 'success';
        } else {//失败
            return 'fail';
        }
    }
}