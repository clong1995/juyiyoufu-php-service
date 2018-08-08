<?php
declare(strict_types=1);

use main\model\impl;

//获取角色
$role = new impl\RoleImpl();
$res = $role->getPage(1);
$data = $res['data'];
?>
<div class="nav" id="nav">
    <span class="title"><i class="iconfont">&#xe60c;</i>角色列表</span>
    <button class="add"><i class="iconfont">&#xe68e;</i>增加角色</button>
    <button class="reload" onclick="location.reload()"><i class="iconfont">&#xe60d;</i>刷新</button>
</div>
<div class="main" id="main">
    <?php
    foreach ($data as $value) {
        ?>
        <div class="item">
            <div class="inner" data-id="<?= $value['role']['id'] ?>">
                <div class="row">
                    <span class="title">名称:</span><?= $value['role']['name'] ?>
                </div>
                <div class="row">
                    <span class="title">说明:</span><?= $value['role']['info'] ?>
                </div>
                <div class="row row3">
                    <span class="title">权限:</span>
                    <ul>
                        <?php
                        foreach ($value['privilege'] as $value1) {
                            ?>
                            <li>
                                <span class="name"><?= $value1['name'] ?></span>
                                <span class="type"><?= $value1['type'] ?></span>
                                <span class="option li-detail"><i class="iconfont">&#xe60e;</i></span>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <div class="option">
                    <button class="edit"><i class="iconfont">&#xe626;</i>编辑</button>
                    <button class="detail"><i class="iconfont">&#xe60e;</i>详情</button>
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
    $res = $role->totalPage();
    $totalPage = $res['data'];
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