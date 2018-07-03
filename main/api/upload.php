<?php

use model\impl;

switch (ORDER) {
    case 'file'://添加
        $file = new impl\UploadImpl();
        $res = $file->image(PARAM['fileUpload'], 'file', 200, ['png', 'jpg', 'jpeg']);
        response($res['type'], $res['data']);
        break;

}