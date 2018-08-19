//翻页
page(v => `<div class="inner" data-id="${v.id}">
        <div class="row">
            <span class="title">名称:</span>${v.name}
        </div>
        <div class="row row2">
            <span class="title">类型:</span>${v.type}
        </div>
        <div class="row row3">
            <span class="title">资源:</span>${v.path}
        </div>
        <div class="row row4">
            <span class="title">说明:</span>
            <p>${v.info}</p>
        </div>
        <div class="option">
            <button class="edit"><i class="iconfont">&#xe626;</i>编辑</button>
            <button class="delete"><i class="iconfont">&#xe60e;</i>删除</button>
        </div>
    </div>`
);