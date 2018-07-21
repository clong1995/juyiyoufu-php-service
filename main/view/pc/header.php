<?php
//根据$routeArr查询数据库的页面信息，标题，描述，访问量，跟新时间，修改时间，国际化等
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>nurse</title>
    <!-- 全局样式 -->
    <link rel="stylesheet" href="/cnd/public/style/public.css">
    <?php
    //列表页样式
    if (strpos(PATH, '/part/list/') !== false) {
        ?>
        <link rel="stylesheet" href="/cnd/public/style/list.css">
        <?php
    }
    //增加页面样式
    if (strpos(PATH, '/part/add/') !== false) {
        ?>
        <link rel="stylesheet" href="/cnd/public/style/add.css">
        <?php
    }
    //编辑页面样式
    if (strpos(PATH, '/part/edit/') !== false) {
        ?>
        <link rel="stylesheet" href="/cnd/public/style/edit.css">
        <?php
    }


    //引入各个模块自己的样式
    $stylePath = PATH . 'style.css';
    if (file_exists($stylePath)) {
        $styleSize = filesize($stylePath);
        if ($styleSize) {
            $styleOpen = fopen($stylePath, 'r');
            ?>
            <style><?= fread($styleOpen, $styleSize) ?></style>
            <?php
            fclose($styleOpen);
        }
    }
    ?>
    <script src="/cnd/public/lib/EasyScript/EBase.class.js"></script>
    <?php
    $scriptPath = PATH . "script.js";
    if (file_exists($scriptPath)) {
        $scriptSize = filesize($scriptPath);
        if ($scriptSize) {
            $scriptOpen = fopen($scriptPath, 'r');
            ?>
            <script><?= fread($scriptOpen, $scriptSize) ?></script>
            <?php
            fclose($scriptOpen);
        }
    }
    ?>
</head>
<body>