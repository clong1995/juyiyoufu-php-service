<?php
use model\impl;
$power = new impl\PowerImpl();
$res = $power->getAllType();
?>
<div class="nav" id="nav">
    <span class="title"><i class="iconfont">&#xe60c;</i>增加权限</span>
    <button class="save"><i class="iconfont">&#xe68e;</i>保存</button>
    <button class="back"><i class="iconfont">&#xe620;</i>返回</button>
</div>
<div id="main" class="main">
    <form class="form">
    <table>
        <tr>
            <td class="title">名称</td>
            <td class="value"><input name="name" type="text"/></td>
        </tr>
        <tr>
            <td class="title">类型</td>
            <td>
                <select name="type">
                    <option value=""></option>
                    <?php
                    foreach ($res as $value){
                        ?>
                        <option value="<?=$value['privilege_type_id']?>"><?=$value['name']?></option>
                    <?php
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="title">资源</td>
            <td>
                <input name="path" type="text"/>
            </td>
        </tr>
        <tr>
            <td class="title">描述</td>
            <td>
                <textarea name="info"></textarea>
            </td>
        </tr>
    </table>
    </form>
</div>