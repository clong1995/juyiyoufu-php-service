<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-6-24
 * Time: 上午6:57
 */

namespace main\db;

interface User  extends Base
{
    public function has(int $id, string $license): array;
}