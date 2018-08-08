//全自动公共方法
ejs.ready(() => {
    let nav = ejs.query('#nav'),
        main = ejs.query('#main'),
        domain = document.location.pathname.split('/')[1];

    //点击警告
    ejs.on('.error', main, 'click', t => {
        ejs.query('.info', t, true).forEach(v => ejs.remove(v));
        ejs.removeClass(t, 'error');
    });

    //返回
    ejs.on('.back', nav, 'click', t => ejs.link('/' + domain + '/list'));
});

//需要参数的方法
function save(verify, fn) {
    let nav = ejs.query('#nav'),
        main = ejs.query('#main'),
        form = ejs.query('.form', main),
        domain = document.location.pathname.split('/')[1];

    ejs.on('.save', nav, 'click', t => {
        fn && fn();
        NEW(ejs.root + 'ui/form.ui', {
            form: form,
            action: '/api/' + domain + '/add',
            verify: verify
        }, res => {
            if (res.state !== 'success') {
                if (typeof res.data === 'string') {
                    //TODO 错误提示
                    alert(res.data);
                    return;
                }
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
            } else {
                ejs.link('/' + domain + '/list');
            }
        });
    });
}