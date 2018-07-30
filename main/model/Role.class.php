<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-1
 * Time: 上午1:45
 */
declare(strict_types=1);

namespace main\model;


interface Role
{
    /**
     * 获取权限类型
     * @param int $page
     * @param int $size
     * @return array
     */
    public function getPage(int $page, int $size): array;

    /**
     * @param int $roleId
     * @return array
     */
    public function getById(int $roleId): array;

    /**
     * 角色关联权限
     * @param $roleId
     * @param $privilegeId
     * @return mixed
     */
    public function relPrivilege(int $roleId, int $privilegeId): array;

    /**
     * 返回总页数
     * @param int $pageSize
     * @return array
     */
    public function totalPage(int $pageSize): array;

    /**
     * @param array $data
     * @return array
     */
    public function update(array $data): array;

    /**
     * @param array $data
     * @return array
     */
    public function delPrivilege(array $data): array;
}