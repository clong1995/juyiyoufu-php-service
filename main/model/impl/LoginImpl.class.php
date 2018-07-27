<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-6-26
 * Time: 上午1:28
 */

namespace main\model\impl;

use EasyPhp\util\Util;
use main\model\Login;
use main\db\impl;
use main\db\conn\Mysql;

class LoginImpl implements Login
{

    //数据库句柄
    private $handle = null;

    public function __construct()
    {
        $this->handle = Mysql::getHandle();
    }

    public function pc($phone, $password)
    {
        if (count($phone) > 11 || count($phone) < 1) {
            return ['state' => 'fail', 'data' => '手机号不合法！'];
        }

        if (count($password) > 32 || count($password) < 1) {
            return ['state' => 'fail', 'data' => '密码不合法！'];
        }


        $employee = new impl\EmployeeImpl($this->handle);


        $res = $employee->select(['id', 'password'], [
            'phone' => $phone
        ]);

        if ($res['state'] == 'success') {
            //校验密码合法性
            $data = $res['data'][0];
            $str = strtoupper(md5($data['password'] . Util::getSession('salt')));
            if ($str === $password) {
                $employeeId = $data['id'];
                //注册id
                Util::setSession('user_id', $employeeId);
                //注册权限
                $Privilege = new impl\PrivilegeImpl($this->handle);
                $res = $Privilege->getAllByEmployeeId($employeeId);
                if ($res['state'] == 'success') {
                    $data = $res['data'];
                    foreach ($data as &$value)
                        $value = $value['path'];
                    Util::setSession('privilege', $data);
                    //清除salt
                    Util::delSession('salt');
                    return ['state' => 'success', 'data' => '登录成功！'];
                } else {
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