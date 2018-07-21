<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-1
 * Time: 上午1:45
 */

namespace model;


interface Company
{
    public function add($data);
    public function getAll();
}