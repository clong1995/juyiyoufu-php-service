//【electron操作类】
const {send} = NEW_ASYNC(ejs.root + 'electron/electron');

let nav = ejs.query('#nav');
let left = ejs.query('#left');
let main = ejs.query('#main');

//最小化
ejs.on('.winMin', nav, 'click', t => send('window/mainMin'));
//最大化
ejs.on('.winMax', nav, 'click', t => {
    ejs.toggleClass(t, 'winMax', 'winUnMax');
    send('window/mainMax');
});
//取消最大化
ejs.on('.winUnMax', nav, 'click', t => {
    ejs.toggleClass(t, 'winUnMax', 'winMax');
    send('window/mainUnMax')
});
//关闭
ejs.on('.winClose', nav, 'click', t => send('window/close'));

//菜单列表
let items = '';
DATA.menu.forEach(v => items += `<div class="item" data-value="${v.path}"><i class="iconfont">${v.icon}</i>${v.name}</div>`);
ejs.html(ejs.query('.list', left), items);
//点亮第一个菜单
let first = ejs.query('.item', left);
ejs.addClass(first, 'active');
module(main, ejs.attr(first, 'data-value'));
//点击菜单
ejs.on('.item', left, 'click', t => {
    if (ejs.hasClass(t, 'active')) return;
    ejs.removeClass(ejs.query('.active', left), 'active');
    ejs.addClass(t, 'active');
    //TODO 加载子模块
    let path = ejs.attr(t, 'data-value');
    module(main, path);
});