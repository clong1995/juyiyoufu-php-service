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

        if ($res && count($res) == 1) {//成功
            $_SESSION['id'] = $res[0]['id'];
            return['state'=>'success','data'=>'注册成功！'];
        } else {//失败
            return ['state'=>'fail','data'=>'注册失败！'];
        }
    }
}