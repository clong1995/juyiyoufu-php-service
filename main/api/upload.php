<?php

use main\model\impl;
use EasyPhp\util\Util;

switch (ORDER) {
    case 'file'://添加
        $file = new impl\UploadImpl();

        $res = $file->image(PARAM['fileUpload'], 1024, ['png', 'jpg', 'jpeg']);
        Util::response($res['state'], $res['data']);
        break;

}