<?php
declare(strict_types=1);

use main\model\impl;

//获取菜单
/*$xxx = new impl\XxxImpl();
$res = $xxx->getPage(1);
$data = $res['data'];*/
$data = [1,2,3,4,5];
?>
<div class="nav" id="nav">
    <span class="title"><i class="iconfont">&#xe60c;</i>权限列表</span>
    <button class="add"><i class="iconfont">&#xe68e;</i>增加菜单</button>
    <button class="reload" onclick="location.reload()"><i class="iconfont">&#xe60d;</i>刷新</button>
</div>
<div class="main" id="main">
    <?php
    foreach ($data as $value) {
        ?>
        <div class="item">
            <div class="inner" data-id="">
                <div class="row">
                    <span class="title">标题1:</span>
                    内容1
                </div>
                <div class="row row2">
                    <span class="title">标题2</span>
                    内容2
                </div>
                <div class="option">
                    <button class="edit"><i class="iconfont">&#xe626;</i>编辑</button>
                    <button class="delete"><i class="iconfont">&#xe60e;</i>删除</button>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>
<div class="page" id="page">
    <?php
    //获取总数
    /*$res = $privilege->totalPage();
    $totalPage = $res['data'];*/
    $totalPage = 2;
    ?>
    <span class="active">1</span>
    <?php
    for ($i = 2; $i <= $totalPage; ++$i) {
        ?>
        <span><?= $i ?></span>
        <?php
    }
    ?>
</div>