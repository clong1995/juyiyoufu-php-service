//【electron操作类】
const {send/*, listen*/} = NEW_ASYNC(ejs.root + 'electron/electron');

ejs.ready(() => {
    let nav = ejs.query('#nav');
    let left = ejs.query('#left');
    ejs.addClass(ejs.query('.item', left), 'active');

    //最小化
    ejs.on('.winMin', nav, 'click', t => send('window/mainMin'));
    //最大化
    ejs.on('.winMax', nav, 'click', t => {
        ejs.toggleClass(t, 'winMax', 'winUnMax');
        send('window/mainMax');
    });
    ejs.on('.winUnMax', nav, 'click', t => {
        ejs.toggleClass(t, 'winUnMax', 'winMax');
        send('window/mainUnMax')
    });
    //关闭
    ejs.on('.winClose', nav, 'click', t => send('window/close'));

    ejs.on('.item', left, 'click', t => {
        if (!ejs.hasClass(t, 'active')) {
            ejs.removeClass(ejs.query('.active', left), 'active');
            ejs.addClass(t, 'active');
        }
    })
});