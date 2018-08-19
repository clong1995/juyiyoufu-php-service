ejs.ready(() => {
    let main = ejs.query('#main');
    let nav = ejs.query('#nav');
    let headImg = ejs.query('.headImg', main);
    let idCardImg = ejs.query('.idCardImg', main);
    let workCardImg = ejs.query('.workCardImg', main);

    //头像上传
    NEW(ejs.root + 'ui/upload.ui', {
        accept: ['image/png', 'image/jpeg'],
        dom: headImg,
        action: '/api/upload/file',
        content: headImg,
        callback: res => {
            ejs.css(headImg, {
                color: 'transparent'
            });
            ejs.html(ejs.query('span', headImg), '重新上传');
            if (res.state === 'success') {
                ejs.query('input[name="headImg"]', main).value = res.data.id;
            } else {
                //上传失败
            }
        }
    });


    //身份证上传
    NEW(ejs.root + 'ui/upload.ui', {
        accept: ['image/png', 'image/jpeg'],
        dom: idCardImg,
        action: '/api/upload/file',
        content: ejs.query('.idCardImgContent', main),
        callback: res => {
            if (res.state === 'success') {
                ejs.query('input[name="idCardImg"]', main).value = res.data.id;
            } else {
                //上传失败
            }
        }
    });

    //工作证上传
    NEW(ejs.root + 'ui/upload.ui', {
        accept: ['image/png', 'image/jpeg'],
        dom: workCardImg,
        action: '/api/upload/file',
        content: ejs.query('.workCardImgContent', main),
        callback: res => {
            if (res.state === 'success') {
                ejs.query('input[name="workCardImg"]', main).value = res.data.id;
            } else {
                //上传失败
            }
        }
    });


    //提交按钮
    ejs.on('.save', nav, 'click', t => {
        let form = ejs.query('.form', main);
        NEW(ejs.root + 'ui/form.ui', {
            form: form,
            action: 'api/nurse/add',
            verify: {
                'headImg': 'string 32',
                'name': 'zh 5',
                'sex': 'number 1',
                'phone': 'number 11',
                'birth': 'date',
                'work': 'date',
                'entry': 'date',
                'loc': 'string 100',
                'item[]': 'notNull',
                'province': 'number 2',
                'city': 'number 2',
                'region': 'number 2',
                'tag[]': 'notNull',
                'case[]': 'notNull',
                'idCard': 'string 20',
                'idCardImg': 'string 32',
                'workCardImg': 'string 32',
                'intro': 'string 100'
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
            }
        });
    });

    ejs.on('.error', main, 'click', t => {
        ejs.query('.info', t, true).forEach(v => ejs.remove(v));
        ejs.removeClass(t, 'error');
    });

    //返回
    ejs.on('.back', nav, 'click', t => ejs.link('/pc/nurse/part/list'));
});