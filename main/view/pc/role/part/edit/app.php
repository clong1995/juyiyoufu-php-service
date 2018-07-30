<?php
declare(strict_types=1);

use main\model\impl;

//获取角色
$role = new impl\RoleImpl();

$roles = $role->getById((int)PARAM['id']);

//获取所有权限
$power = new impl\PowerImpl();
$powers = $power->getAll();
$powersData = $powers['data'];

?>
<div class="nav" id="nav">
    <span class="title"><i class="iconfont">&#xe60c;</i>编辑角色</span>
    <button class="save"><i class="iconfont">&#xe68e;</i>保存</button>
    <button class="back"><i class="iconfont">&#xe620;</i>返回</button>
</div>
<div id="main" class="main">
    <form class="form">
        <input type="hidden" class="role" name="id" value="<?= $roles['role']['id'] ?>">
        <table>
            <tbody>
            <tr>
                <td class="title">名称</td>
                <td><input type="text" name="name" value="<?= $roles['role']['name'] ?>"></td>
            </tr>
            <tr>
                <td class="title">说明</td>
                <td><textarea name="info"><?= $roles['role']['info'] ?></textarea></td>
            </tr>
            <tr>
                <td class="title">权限列表</td>
                <td>
                    <ul class="list">
                        <?php
                        foreach ($roles['privilege'] as $key => $value) {
                            ?>
                            <li data-id="<?= $key ?>">
                                <span class="name"><?= $value['name'] ?></span>
                                <span class="type"><?= $value['type'] ?></span>
                                <span class="option delete"><i class="iconfont">&#xe604;</i></span>
                                <span class="option detail"><i class="iconfont">&#xe60e;</i></span>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                    <div class="opt">
                        <span class="title"><i class="iconfont">&#xe61d;</i>关联权限：</span>
                        <select class="privilege">
                            <option></option>
                            <?php
                            foreach ($powersData as $value) {
                                ?>
                                <option value="<?= $value['id'] ?>">
                                    <?= $value['name'] ?>
                                    [<?= $value['type'] ?>]
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                        <button type="button" class="addPrivilege">关联</button>

                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>