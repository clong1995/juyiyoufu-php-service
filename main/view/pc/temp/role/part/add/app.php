<?php
declare(strict_types=1);

use main\model\impl;

//获取角色
$role = new impl\RoleImpl();

//获取所有权限
$power = new impl\PowerImpl();
$powers = $power->getAll();
$powersData = $powers['data'];
?>
<div class="nav" id="nav">
    <span class="title"><i class="iconfont">&#xe60c;</i>添加角色</span>
    <button class="save"><i class="iconfont">&#xe68e;</i>保存</button>
    <button class="back"><i class="iconfont">&#xe620;</i>返回</button>
</div>
<div id="main" class="main">
    <form class="form">
        <table>
            <tbody>
            <tr>
                <td class="title">名称</td>
                <td><input type="text" name="name" value=""></td>
            </tr>
            <tr>
                <td class="title">标识</td>
                <td><input type="text" name="role_name" value=""></td>
            </tr>
            <tr>
                <td class="title">说明</td>
                <td><textarea name="info"></textarea></td>
            </tr>
            <tr>
                <td class="title">权限列表</td>
                <td>
                    <ul class="list">

                    </ul>
                    <div class="opt">
                        <span class="title"><i class="iconfont">&#xe61d;</i>关联权限：</span>
                        <input name="privilege" value="" type="hidden">
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