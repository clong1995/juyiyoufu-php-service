<?php

use model\impl;

//获取菜单
$privilege = new impl\PowerImpl();
$res = $privilege->getAllPower();

$data = $res['data'];

?>
<div class="nav" id="nav">
    <span class="title"><i class="iconfont">&#xe60c;</i>权限列表</span>
    <button class="add"><i class="iconfont">&#xe68e;</i>增加权限</button>
    <button class="reload" onclick="location.reload()"><i class="iconfont">&#xe60d;</i>刷新</button>
</div>
<div class="main" id="main">
    <?php
    foreach ($data as $value) {
        ?>
        <div class="item" data-id="<?= $value['id'] ?>">
            <div class="row">
                <span class="title">名称:</span><?= $value['name'] ?>
            </div>
            <div class="row">
                <span class="title">类型:</span>
                <?= $value['type'] ?>
            </div>
            <div class="row row3">
                <span class="title">资源:</span>
                <?= $value['path'] ?>
            </div>
            <div class="row row4">
                <span class="title">说明:</span>
                <p>
                    <?= $value['info'] ?>
                </p>
            </div>
            <div class="option">
                <button class="edit"><i class="iconfont">&#xe626;</i>编辑</button>
                <button class="delete"><i class="iconfont">&#xe60e;</i>删除</button>
            </div>
        </div>
        <?php
    }
    ?>
</div>
<div class="page">
    <?php
    for ($i = 0; $i < 9; ++$i) {
        ?>
        <span><?= $i ?></span>
        <?php
    }
    ?>
</div>