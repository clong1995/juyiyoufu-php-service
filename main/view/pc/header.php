<?php
//根据$routeArr查询数据库的页面信息，标题，描述，访问量，跟新时间，修改时间，国际化等

declare(strict_types=1);

use EasyPhp\util\Util;

?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>nurse</title>
    <!-- 全局样式 -->
    <link rel="stylesheet" href="/cdn/pc/style/public.css">
    <!-- 模块样式 -->
    <style><?= Util::readFile(PATH . 'style.css') ?></style>
    <!-- 基类 -->
    <script src="/cdn/lib/EasyScript/EBase.class.js"></script>
    <!-- 公共脚本 -->
    <script src="/cdn/pc/script/public.js"></script>
    <!-- 模块自己的类 -->
    <script>
        ejs.ready(() => {
            <?php
            include PATH . 'data.php';
            echo Util::readFile(PATH . "script.js");
            ?>
            document.querySelectorAll('script').forEach(v=>ejs.remove(v));
        })
    </script>
</head>
<body>