<?php
/**
 * Created by IntelliJ IDEA.
 * User: clong
 * Date: 18-7-1
 * Time: 上午1:51
 */

namespace model\impl;


use model\Authorize;
use db\impl;

class AuthorizeImpl implements Authorize
{
    public function check($path)
    {
        /*//查询是否有此权限
        $privilege = new impl\PrivilegeImpl();
        $res = $privilege->select(['id'], [
            'path' => $path
        ]);

        if($res && count($res) == 1){
            $privilegeId = $res[0]['id'];
            //检查此用户是否有权限
            $res = $privilege->countByEmployeeAndPrivilege(getSession('id'),$privilegeId);
            if($res[0]['count'] == 1){
                return ['state'=>'success','data'=>'认证成功'];
            }else{
                return ['state'=>'fail','data'=>'无使用权限'];
            }
        }else{//权限不存在
            return ['state'=>'success','data'=>'功能未注册'];
        }*/
    }

}