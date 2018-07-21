<?php

use model\impl;

//获取菜单
$company = new impl\CompanyImpl();
$res = $company->getAll();
$data = $res['data'];
?>
<div class="nav" id="nav">
    <span class="title"><i class="iconfont">&#xe60c;</i>公司列表</span>
    <button class="add"><i class="iconfont">&#xe68e;</i>增加公司</button>
    <button class="reload" onclick="location.reload()"><i class="iconfont">&#xe60d;</i>刷新</button>
</div>
<div class="main">
    <?php
    foreach ($data as $value) {
        ?>
        <div class="item">
            <div class="row row1">
                <img src="/<?=$value['path'].'/'.$value['logo']?>">
            </div>
            <div class="row row2"><span class="title">公司名称</span><?=$value['company']?></div>
            <div class="row row3"><span class="title">负责人</span><?=$value['employee']?></div>
            <div class="row row4"><span class="title">联系电话</span><?=$value['phone']?></div>
            <div class="row row4"><span class="title">地址</span><?=$value['province'].$value['city'].$value['area']?></div>
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