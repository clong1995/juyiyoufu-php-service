<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-1
 * Time: 上午1:51
 */

namespace main\model\impl;


use EasyPhp\util\Util;
use main\model\IndexMenu;
use main\db\impl;
use main\db\conn\Mysql;

class IndexMenuImpl implements IndexMenu
{
    //数据库句柄
    private $handle = null;

    public function __construct()
    {
        $this->handle = Mysql::getHandle();
    }

    public function getIndexMenu()
    {
        $indexMenu = new impl\IndexMenuImpl($this->handle);
        $res = $indexMenu->getAllByEmployeeId(Util::getSession('user_id'));
        if($res['state'] === 'success'){
            foreach ($res['data'] as &$value){
                $value = str_replace('pc/','',$value);
            }
        }
        return $res;
    }

}