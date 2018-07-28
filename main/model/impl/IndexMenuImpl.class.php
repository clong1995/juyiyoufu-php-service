<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-1
 * Time: 上午1:51
 */

declare(strict_types=1);

namespace main\model\impl;


use EasyPhp\util\Util;
use main\model\IndexMenu;
use main\db\impl;
use main\db\conn\Mysql;
use \Exception;

class IndexMenuImpl implements IndexMenu
{
    //数据库句柄
    private $handle = null;

    public function __construct()
    {
        $mysql = new Mysql();
        $this->handle = $mysql->pdo;
    }

    public function getIndexMenu(): array
    {
        $indexMenu = new impl\IndexMenuImpl($this->handle);
        try {
            $res = $indexMenu->getAllByEmployeeId((int)Util::getSession('user_id'));
        } catch (Exception $e) {
            //TODO 日志
            return ['state' => 'fail', 'data' => '获取首页菜单失败！'];
        }

        foreach ($res as &$value) {
            $value = str_replace('pc/', '', $value);
        }

        return ['state' => 'success', 'data' => $res];
    }

}