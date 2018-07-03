//【electron操作类】
const {send} = NEW_ASYNC(ejs.root + 'electron/electron');
ejs.ready(() => {
    //登录注册块
    let login = ejs.query('#login');

    //切换登录注册
    let signLogin = ejs.query('#signLogin');

    //标题栏模块
    let header = ejs.query('#header');

    //信息框
    let msg = ejs.query('.msg', login);

    //点击登录
    ejs.on('.login-btn', login, 'click', t => loginSign('/api/login/pc'));

    //点击注册
    ejs.on('.sign-btn', login, 'click', t => ejs.query('.password', login).value === ejs.query('.password1', login).value
        ? loginSign('/api/signin/pc')
        : ejs.html(msg, '密码不一致！'));

    //去掉信息
    ejs.on('INPUT', login, 'click', t => ejs.empty(msg));

    //点击切换注册
    ejs.on('.sign', signLogin, 'click', t => {
        //隐藏注册
        ejs.hide(t, {
            duration: .1
        });
        //显示登录
        ejs.show(ejs.query('.back', signLogin), {
            duration: .1
        });
        //显示重复密码和注册按钮
        ejs.show(ejs.query('.sign-box', login), {
            duration: .1
        });
        //隐藏登录按钮
        ejs.hide(ejs.query('.login-btn', login), {
            duration: .1
        });
    });
    //点击切换登录
    ejs.on('.back', signLogin, 'click', t => {
        ejs.hide(t);
        //显示注册
        ejs.show(ejs.query('.sign', signLogin));
        //隐藏重复密码和注册按钮
        ejs.hide(ejs.query('.sign-box', login), {
            duration: .1
        });
        //显示登录按钮
        ejs.show(ejs.query('.login-btn', login), {
            duration: .5
        });
    });

    //关闭
    ejs.on('.close', header, 'click', t => send('window/close'));


    function loginSign(url) {

        let phone = ejs.query('.phone', login),
            password = ejs.query('.password', login);

        //校验字段
        if (!phone.value) {
            ejs.html(msg, '手机号不得为空！');
            return;
        }
        if (!password.value) {
            ejs.html(msg, '密码不得为空！');
            return;
        }

        if (!/^[0-9]*$/.test(phone.value) || phone.value.length !== 11) {
            ejs.html(msg, '手机号格式错误！');
            return;
        }

        if (password.value.length > 20 || password.value < 6) {
            ejs.html(msg, '密码需要6至20位任意字符！');
            return;
        }

        ejs.ajax(url, {
            method: 'POST',
            data: {
                phone: phone.value,
                password: ejs.md5(password.value)
            },
            success: res => res.state === 'success'
                ? send('login/login')
                : ejs.html(msg, '用户名或密码错误！'),
            error: res => {

            }
        })
    }
})
;
