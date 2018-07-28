<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-6-26
 * Time: 上午1:24
 */
declare(strict_types=1);

namespace main\model;


interface Login
{
    public function pc(string $phone,string $password);
}