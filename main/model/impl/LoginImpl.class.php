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

        if (count($phone) > 11 || count($phone) < 1) {
            return ['state' => 'fail', 'data' => '手机号不合法！'];
        }

        if (count($password) > 32 || count($password) < 1) {
            return ['state' => 'fail', 'data' => '密码不合法！'];
        }

        $employee = new impl\EmployeeImpl();
        $res = $employee->select(['id', 'password'], [
            'phone' => $phone
        ]);

        if ($res['state'] == 'success') {
            //校验密码合法性
            $data = $res['data'][0];
            $str = strtoupper(md5($data['password'] . getSession('salt')));
            if ($str === $password) {
                $employeeId = $data['id'];
                //注册id
                setSession('id', $employeeId);
                //注册权限
                $Privilege = new impl\PrivilegeImpl();
                $res = $Privilege->getAllByEmployeeId($employeeId);
                if($res['state'] == 'success'){
                    $data = $res['data'];
                    foreach ($data as &$value)
                        $value = $value['path'];
                    setSession('privilege', $data);
                    //清除salt
                    delSession('salt');
                    return ['state' => 'success', 'data' => '登录成功！'];
                }else{
                    return ['state' => 'fail', 'data' => '权限注册错误！'];
                }
            } else {
                return ['state' => 'fail', 'data' => '密码错误！'];
            }
        } else {
            return ['state' => 'fail', 'data' => '用户不存在！'];
        }
    }
}