ejs.ready(() => {
    let nav = ejs.query('#nav');
    let main = ejs.query('#main');
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
    });

    //返回
    ejs.on('.back', nav, 'click', t => ejs.link('/pc/power/part/list'));
});