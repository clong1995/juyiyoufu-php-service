<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-1
 * Time: 上午1:51
 */

namespace model\impl;


use model\IndexMenu;
use db\impl;

class IndexMenuImpl implements IndexMenu
{
    public function getIndexMenu()
    {
        $indexMenu = new impl\IndexMenuImpl();
        $res = $indexMenu->getAllByEmployeeId(getSession('id'));
        return $res;
    }

}