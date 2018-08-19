<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-6-24
 * Time: 上午6:57
 */

declare(strict_types=1);

namespace main\db;

interface Menu extends Base
{
    public function getAllByUserId(int $userId, int $type): array;

    public function getLimit(int $start, int $size): array;
}