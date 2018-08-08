<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-1
 * Time: 上午1:45
 */

declare(strict_types=1);

namespace main\model;

interface Regional
{
    public function province(): array;

    public function city(int $id): array;

    public function area(int $id): array;
}