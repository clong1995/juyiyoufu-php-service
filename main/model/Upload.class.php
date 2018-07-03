<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-1
 * Time: 上午1:45
 */

namespace model;


interface Upload
{
    public function image($file,$path,$size=1024,$allowed=[]);
    public function file($file,$path,$size=1024,$allowed);
}