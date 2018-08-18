<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-1
 * Time: 上午1:45
 */

declare(strict_types=1);

namespace main\model;


interface Company
{
    public function add(array $data): array;

    public function getAll(): array;

    public function getPage(int $page): array;

    public function delete(int $id): array;

    public function getById(int $id): array;

    public function totalPage(): array;

    public function update(array $data): array;
}