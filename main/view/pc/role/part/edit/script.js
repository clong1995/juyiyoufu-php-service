let main = ejs.query('#main');
let list = ejs.query('.list', main);
let privilege = ejs.query('.privilege', main);

let roleId = ejs.query('.role', main).value;

//关联权限
ejs.on('.addPrivilege', main, 'click', t => {

    //id
    let privilegeId = privilege.value;
    if (privilegeId === '') {
        ejs.addClass(privilege, 'pri_error');
        return;
    }

    ejs.ajax('/api/role/relPrivilege', {
        method: 'POST',
        data: {
            privilegeId: privilegeId,
            roleId: roleId
        },
        success: data => {
            if (data.state === 'success') {
                //文本
                let textArr = privilege.options[privilege.selectedIndex].text.split(' ['),
                    nameText = textArr[0],
                    typeText = textArr[1].substring(0, textArr[1].length - 1);

                //节点
                let li = `<li data-id="2">
                    <span class="name">${nameText}</span>
                    <span class="type">${typeText}</span>
                    <span class="option delete"><i class="iconfont">&#xe604;</i></span>
                    <span class="option detail"><i class="iconfont">&#xe60e;</i></span>
                </li>`;

                ejs.html(list, li, true);
            } else {
                console.log(data.data);
            }
        }
    });
});

//去掉关联错误
ejs.on('.pri_error', main, 'click', t => ejs.removeClass(t, 'pri_error'));


//保存修改
save({
    'id': 'number 20',
    'name': 'string 10',
    'info': 'string 100'
});

//删除关联的权限
ejs.on('.delete', main, 'click', t => {
    let target = t.parentNode,
        privilegeId = ejs.attr(target, 'data-id');
    ejs.ajax('/api/role/delPrivilege', {
        method: 'POST',
        data: {
            privilegeId: privilegeId,
            roleId: roleId
        },
        success: data => {
            if (data.state === 'success') {
                ejs.remove(target);
            } else {
                //TODO
                alert();
            }
        }
    })
});