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
            return ['state' => false, 'data' => '手机号不合法！'];
        }
        if (strlen($password) > 32 || strlen($password) < 1) {
            return ['state' => false, 'data' => '密码不合法！'];
        }

        $user = new impl\UserImpl($this->handle);

        try {
            $res = $user->select(['user_id', 'password'], ['phone' => $phone]);
        } catch (Exception $exception) {
            //TODO 记录日志
            $code = $exception->getCode() . time() . Util::random();
            return ['state' => false, 'data' => '登录失败！','exception' => $code];
        }


        if (count($res) === 1) {
            //校验密码合法性
            $data = $res[0];
            $str = strtoupper(md5($data['password'] . Util::getSession('salt')));

            if (!strcmp($str, $password)) {
                $userId = (int)$data['user_id'];
                //注册权限
                $privilege = new impl\PrivilegeImpl($this->handle);
                try {
                    $privilegeData = $privilege->getAllByUserId($userId,2);
                } catch (Exception $exception) {
                    //TODO 写日志
                    $code = $exception->getCode() . time() . Util::random();
                    return ['state' => false, 'data' => '权限注册失败！','exception' => $code];
                }

                //当前用户的菜单
                $menu = new impl\MenuImpl($this->handle);
                try {
                    $menuData = $menu->getAllByUserId($userId,2);
                } catch (Exception $exception) {
                    //TODO 写日志
                    $code = $exception->getCode() . time() . Util::random();
                    return ['state' => false, 'data' => '菜单注册错误！', 'exception' => $code];
                }

                //只提取path部分作为权限
                foreach ($privilegeData as &$value)
                    $value = $value['path'];

                //注册id
                Util::setSession('user_id', $userId);
                Util::setSession('privilege', $privilegeData);
                Util::setSession('menu', $menuData);
                //清除salt
                Util::delSession('salt');
                return ['state' => true, 'data' => '登录成功！'];
            } else {
                return ['state' => false, 'data' => '密码错误！'];
            }
        } else {
            return ['state' => false, 'data' => '用户不存在！'];
        }
    }
}