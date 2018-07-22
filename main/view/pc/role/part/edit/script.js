ejs.ready(() => {
    let nav = ejs.query('#nav');
    let main = ejs.query('#main');
    let list = ejs.query('.list', main);

    //关联权限
    ejs.on('.addPrivilege', main, 'click', t => {

        //id
        let privilege = ejs.query('.privilege', main);
        let privilegeId = privilege.value;

        if (privilegeId === '') {
            ejs.addClass(privilege, 'pri_error');
            return;
        }


        let roleId = ejs.query('.role', main).value;

        ejs.ajax('/api/role/relPrivilege', {
            method: 'POST',
            data: {
                privilegeId: privilegeId,
                roleId: roleId
            },
            success: data => {
                if (data.state === 'success') {
                    //文本
                    let textArr = privilege.options[privilege.selectedIndex].text.split(' [');
                    let nameText = textArr[0];
                    let typeText = textArr[1].substring(0, textArr[1].length - 1);


                    let itemLi = ejs.createDom('li');
                    let span = ejs.createDom('span');
                    let icon = ejs.createDom('i');
                    ejs.addClass(icon, 'iconfont');

                    //名称
                    let name = span.cloneNode();
                    ejs.html(name, nameText);
                    ejs.addClass(name, 'name');
                    ejs.append(itemLi, name);

                    //类型
                    let type = span.cloneNode();
                    ejs.html(type, typeText);
                    ejs.addClass(type, 'type');
                    ejs.append(itemLi, type);

                    //删除
                    let del = span.cloneNode();
                    let delIcon = icon.cloneNode();
                    delIcon.innerHTML = '&#xe604;';
                    ejs.append(del, delIcon);
                    ejs.addClass(del, 'option');
                    ejs.addClass(del, 'li-del');
                    ejs.append(itemLi, del);

                    //详情
                    let detail = span.cloneNode();
                    let detailIcon = icon.cloneNode();
                    detailIcon.innerHTML = '&#xe60e;';
                    ejs.append(detail, detailIcon);
                    ejs.addClass(detail, 'option');
                    ejs.addClass(detail, 'li-detail');
                    ejs.append(itemLi, detail);

                    ejs.append(list, itemLi);
                } else {
                    console.log(data.data);
                }
            }
        });
    });

    //去掉关联错误
    ejs.on('.pri_error', main, 'click', t => ejs.removeClass(t, 'pri_error'));


    /*
    //增加权限
    ejs.on('.save', nav, 'click', t =>{
        let form = ejs.query('.form', main);
        NEW(ejs.root + 'ui/form.ui', {
            form: form,
            action: '/api/power/add',
            verify: {
                'name': 'string 20',
                'type': 'number 1',
                'path': 'string 50',
                'info': 'string 100'
            }
        }, res => {
            if (res.state !== 'success') {
                let field = ejs.query('*[name="' + res.data.name + '"]', form);
                let td = field.parentNode;

                if (td.tagName !== 'TD') {
                    td = td.parentNode;
                }

                ejs.addClass(td, 'error');
                let error = ejs.query('.error', form);
                let info = ejs.createDom();
                ejs.addClass(info, 'info');
                ejs.html(info, res.data.msg);
                ejs.append(error, info);
            }else{
                ejs.link('/pc/power/part/list');
            }
        });
    });

    ejs.on('.error', main, 'click', t => {
        ejs.query('.info', t, true).forEach(v => ejs.remove(v));
        ejs.removeClass(t, 'error');
    });*/

    //返回
    ejs.on('.back', nav, 'click', t => ejs.link('/pc/role/part/list'));
});