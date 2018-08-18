<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-1
 * Time: 上午1:45
 */

declare(strict_types=1);

namespace main\model;


interface Menu
{
    public function getIndex(): array;

    public function getPage(int $page): array;

    public function totalPage(): array;
    /**
     * 获取管线类型
     * @return array
     */
    public function getAllType(): array;

    public function add(array $data): array;

    public function delete(int $id): array;

    public function update(array $data): array;
}