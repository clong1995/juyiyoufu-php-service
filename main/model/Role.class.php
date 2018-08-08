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
    public function getPage(int $page): array;

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
     * @return array
     */
    public function totalPage(): array;

    /**
     * @param array $data
     * @return array
     */
    public function update(array $data): array;

    /**
     * @param array $data
     * @return array
     */
    public function add(array $data): array;

    /**
     * @param array $data
     * @return array
     */
    public function delPrivilege(array $data): array;

    public function delete(int $id): array;

}