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

/**
 * 需要参数的方法
 * @param verify
 * @param fn
 */
function save(verify, fn = null) {
    let nav = ejs.query('#nav'),
        main = ejs.query('#main'),
        form = ejs.query('.form', main),
        domain = document.location.pathname.split('/')[1];

    ejs.on('.save', nav, 'click', t => {
        //提交前置函数
        fn && fn();
        //提交
        NEW(ejs.root + 'ui/form.ui', {
            form: form,
            action: '/api/' + domain + '/update',
            verify: verify
        }, res => {
            console.log(res);
            if (res.state) {
                ejs.link('/' + domain + '/list');
            } else {
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
            }
        });
    });
}