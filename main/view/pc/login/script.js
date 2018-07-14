//【electron操作类】
const {send} = NEW_ASYNC(ejs.root + 'electron/electron');
ejs.ready(() => {
    //登录注册块
    let login = ejs.query('#login');
    //标题栏模块
    let header = ejs.query('#header');
    //信息框
    let msg = ejs.query('.msg', login);

    //点击登录
    ejs.on('.login-btn', login, 'click', t => {
        let phone = ejs.query('.phone', login),
            password = ejs.query('.password', login),
            salt = ejs.query('.salt', login);

        //校验字段
        if (!phone.value) {
            ejs.html(msg, '手机号不得为空！');
            return;
        }
        if (!password.value) {
            ejs.html(msg, '密码不得为空！');
            return;
        }

        if (/*!/^[0-9]*$/.test(phone.value) || */phone.value.length > 11) {
            ejs.html(msg, '手机号格式错误！');
            return;
        }

        if (password.value.length > 20 || password.value < 6) {
            ejs.html(msg, '密码需要6至20位任意字符！');
            return;
        }

        ejs.ajax('/api/login/pc', {
            method: 'POST',
            data: {
                phone: phone.value,
                password: ejs.md5(ejs.md5(password.value) +''+ salt.value)
            },
            success: res => {
                if (res.state === 'success') {
                    //登录成功
                    send('login/main');
                } else {
                    //通知错误
                    ejs.html(msg, res.data)
                }
            }
        });
    });

    //去掉信息
    ejs.on('INPUT', login, 'click', t => ejs.empty(msg));

    //关闭
    ejs.on('.close', header, 'click', t => send('window/close'));
});
