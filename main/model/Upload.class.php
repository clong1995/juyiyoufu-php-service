<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-1
 * Time: 上午1:45
 */

declare(strict_types=1);

namespace main\model;


interface Upload
{
    public function image(array $file, int $size = 1024, array $allowed = []): array;

    public function file($file, $path, $size = 1024, $allowed);
}