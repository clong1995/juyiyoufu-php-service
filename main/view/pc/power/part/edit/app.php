<?php
declare(strict_types=1);

use main\model\impl;

$power = new impl\PowerImpl();
//权限类型
$res = $power->getAllType();
$type = $res['data'];

//根据id查询权限
$res = $power->getById((int)PARAM[0]);
$onePower = $res['data'];
?>
<div class="nav" id="nav">
    <span class="title"><i class="iconfont">&#xe60c;</i>修改权限</span>
    <button class="save"><i class="iconfont">&#xe68e;</i>保存</button>
    <button class="back"><i class="iconfont">&#xe620;</i>返回</button>
</div>
<div id="main" class="main">
    <form class="form">
        <input type="hidden" name="id" value="<?= (int)PARAM[0] ?>"/>
        <table>
            <tr>
                <td class="title">名称</td>
                <td class="value"><input name="name" type="text" value="<?= $onePower['name'] ?>"/></td>
            </tr>
            <tr>
                <td class="title">类型</td>
                <td>
                    <select name="type">
                        <option value=""></option>
                        <?php
                        foreach ($type as $value) {
                            if ($value['type_id'] == $onePower['privilege_type']) {
                                $selected = 'selected = "selected"';
                            } else {
                                $selected = '';
                            }
                            ?>
                            <option value="<?= $value['type_id'] ?>" <?= $selected ?> ><?= $value['name'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="title">资源</td>
                <td>
                    <input name="path" type="text" value="<?= $onePower['path'] ?>"/>
                </td>
            </tr>
            <tr>
                <td class="title">描述</td>
                <td>
                    <textarea name="info"><?= $onePower['info'] ?></textarea>
                </td>
            </tr>
        </table>
    </form>
</div>