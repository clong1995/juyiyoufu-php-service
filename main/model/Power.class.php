<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-1
 * Time: 上午1:45
 */

declare(strict_types=1);

namespace main\model;


interface Power
{
    /**
     * 添加权限
     * @param $data
     * @return array
     */
    public function add(array $data): array;

    /**
     * @param array $data
     * @return array
     */
    public function update(array $data): array;

    /**
     * 删除权限
     * @param $id
     * @return array
     */
    public function delById(int $id): array;

    /**
     * 获取所有权限
     * @return array
     */
    //public function getAll(): array;

    /**
     * 根据id获取权限
     * @param int $id
     * @return array
     */
    public function getById(int $id): array;

    /**
     * 获取权限类型
     * @return array
     */
    public function getAllType(): array;

    /**
     * 返回总页数
     * @return array
     */
    public function totalPage(): array;

    /**
     * 用于分页
     * @param int $page
     * @return array
     */
    public function getPage(int $page): array;
}