<?php

use model\impl;

//获取菜单
/*$privilege = new impl\PowerImpl();
$res = $privilege->getAllPower();*/
$res = [1,2,3,4,5];
?>
<div class="nav" id="nav">
    <span class="title"><i class="iconfont">&#xe60c;</i>公司列表</span>
    <button class="add"><i class="iconfont">&#xe68e;</i>增加公司</button>
    <button class="reload" onclick="location.reload()"><i class="iconfont">&#xe60d;</i>刷新</button>
</div>
<div class="main">
    <?php
    foreach ($res as $value) {
        ?>
        <div class="item">
            <div class="row row1"></div>
            <div class="row row2"><span class="title">公司名称</span>xxxx公司</div>
            <div class="row row3"><span class="title">负责人</span>李二狗</div>
            <div class="row row4"><span class="title">联系电话</span>15166322145</div>
            <div class="row row4"><span class="title">地址</span>北京市朝阳区酒仙桥路</div>
            <div class="option">
                <button class="edit"><i class="iconfont">&#xe626;</i>编辑</button>
                <button class="detail"><i class="iconfont">&#xe60e;</i>详情</button>
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