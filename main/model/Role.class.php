<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-1
 * Time: 上午1:45
 */

namespace model;


interface Role
{
    /**
     * 获取权限类型
     * @return mixed
     */
    public function getAll();

    /**
     * @param $roleId
     * @return mixed
     */
    public function getAllById($roleId);

    /**
     * 角色关联权限
     * @param $roleId
     * @param $privilegeId
     * @return mixed
     */
    public function relPrivilege($roleId,$privilegeId);
}