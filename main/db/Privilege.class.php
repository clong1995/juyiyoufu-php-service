<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-6-24
 * Time: 上午6:57
 */

namespace main\db;

interface Privilege  extends Base
{
    public function getAllByEmployeeId($employeeId);
    public function getAll();
    public function getPowerById($id);
}