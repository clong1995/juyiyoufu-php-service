<div class="nav" id="nav">
    <span class="title"><i class="iconfont">&#xe60c;</i>护工列表</span>
    <button class="add"><i class="iconfont">&#xe68e;</i>增加护工</button>
    <button class="reload" onclick="location.reload()"><i class="iconfont">&#xe60d;</i>刷新</button>
</div>

<div class="main">
    <?php
    for ($i = 0; $i < 5; ++$i) {
        ?>
        <div class="item">
            <div class="headImg"></div>
            <div class="row row1">
                <span class="name">成龙哥哥</span>
                <i class="iconfont">&#xe615;</i>
                <i class="iconfont">&#xe618;</i>
                <i class="iconfont">&#xe619;</i>
            </div>
            <div class="row row2">
                <span>男</span>
                <span>年龄 20</span>
                <span>工龄 20</span>
                <span>入职 20 个月</span>
            </div>
            <div class="row row3">
                陪护项目： 挂号陪诊 医疗陪护 云游陪护
            </div>
            <div class="row row4">
                陪护区域： 淄博市张店区和平家园
            </div>
            <div class="row row5">
                工作绩效： 总时长20天 总单量10单 <i class="iconfont">&#xe605;</i>5 <i class="iconfont">&#xe617;</i>5
            </div>
            <div class="option">
                <button class="edit"><i class="iconfont">&#xe626;</i>编辑</button>
                <button class="detail"><i class="iconfont">&#xe60e;</i>详情</button>
            </div>
        </div>
        <?php
    }
    ?>
</div>

<div class="page">
    <?php
    for ($i = 0; $i < 9; ++$i) {
        ?>
        <span><?= $i?></span>
        <?php
    }
    ?>
</div>