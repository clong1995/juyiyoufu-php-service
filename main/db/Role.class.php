<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-6-24
 * Time: 上午6:57
 */

declare(strict_types=1);

namespace main\db;

interface Role extends Base
{
    public function getLimit(int $start, int $size): array;

    public function delPrivilege(int $roleId, int $privilegeId): array;

    public function getById(int $roleId): array;

    /**
     * 角色关联权限
     * @param $roleId
     * @param $privilegeId
     * @return mixed
     */
    public function relPrivilege(int $roleId, int $privilegeId): array;
}