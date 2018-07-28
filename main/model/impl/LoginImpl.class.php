<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-6-26
 * Time: 上午1:28
 */

declare(strict_types=1);

namespace main\model\impl;

use EasyPhp\util\Util;
use main\model\Login;
use main\db\impl;
use main\db\conn\Mysql;
use Exception;

class LoginImpl implements Login
{

    //数据库句柄
    private $handle = null;

    public function __construct()
    {
        $mysql = new Mysql();
        $this->handle = $mysql->pdo;
    }

    /**
     * @param string $phone
     * @param string $password
     * @return array
     */
    public function pc(string $phone, string $password): array
    {
        if (strlen($phone) > 11 || strlen($phone) < 1) {
            return ['state' => 'fail', 'data' => '手机号不合法！'];
        }
        if (strlen($password) > 32 || strlen($password) < 1) {
            return ['state' => 'fail', 'data' => '密码不合法！'];
        }

        $employee = new impl\EmployeeImpl($this->handle);
        try {
            $res = $employee->select(['id', 'password'], ['phone' => $phone]);
        } catch (Exception $e) {
            //TODO 记录日志
            return ['state' => 'fail', 'data' => '登录失败！'];
        }


        if (count($res) === 1) {
            //校验密码合法性
            $data = $res[0];
            $str = strtoupper(md5($data['password'] . Util::getSession('salt')));

            if (!strcmp($str, $password)) {
                $employeeId = (int)$data['id'];
                //注册权限
                $Privilege = new impl\PrivilegeImpl($this->handle);
                try {
                    $res = $Privilege->getAllByEmployeeId($employeeId);
                } catch (Exception $e) {
                    return ['state' => 'fail', 'data' => '权限注册错误！'];
                }
                //只提取path部分作为权限
                foreach ($res as &$value)
                    $value = $value['path'];

                //注册id
                Util::setSession('user_id', $employeeId);
                Util::setSession('privilege', $res);
                //清除salt
                Util::delSession('salt');
                return ['state' => 'success', 'data' => '登录成功！'];
            } else {
                return ['state' => 'fail', 'data' => '密码错误！'];
            }
        } else {
            return ['state' => 'fail', 'data' => '用户不存在！'];
        }
    }
}