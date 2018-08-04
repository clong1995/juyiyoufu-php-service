<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-6-24
 * Time: 上午6:57
 */

declare(strict_types=1);

namespace main\db;

interface Company extends Base
{
    public function getAll(): array;

    public function getLimit(int $start, int $size): array;

    public function getById(int $id): array;

    public function has(int $id, string $license): array;
}