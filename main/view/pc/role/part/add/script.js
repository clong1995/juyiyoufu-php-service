let main = ejs.query('#main');
let list = ejs.query('.list', main);
let privilege = ejs.query('.privilege', main);

let privilegeSet = new Set();
//关联权限
ejs.on('.addPrivilege', main, 'click', t => {

    //id
    let privilegeId = privilege.value;
    if (privilegeId === '') {
        ejs.addClass(privilege, 'pri_error');
        return;
    }
    privilegeSet.add(privilegeId);

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
});

//去掉关联错误
ejs.on('.pri_error', main, 'click', t => ejs.removeClass(t, 'pri_error'));

//删除关联的权限
ejs.on('.delete', list, 'click', t => {
    console.log(t);
    let target = t.parentNode,
        privilegeId = ejs.attr(target, 'data-id');
    privilegeSet.delete(privilegeId);
    ejs.remove(target);
});

//保存
save({
        'name': 'string 10',
        'info': 'string 100',
        'role_name': 'string 10',
        'privilege': 'string 100'
    }, () =>
        ejs.query('input[name=privilege]', main).value = [...privilegeSet].join(',')
);