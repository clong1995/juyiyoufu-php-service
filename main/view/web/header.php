<?php
//根据$routeArr查询数据库的页面信息，标题，描述，访问量，跟新时间，修改时间，国际化等
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>nurse</title>
    <?php
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