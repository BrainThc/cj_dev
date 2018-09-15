<?php
namespace app\admin\model;
use think\Db;
use think\Model;

/**
 * 管理员账号model
 * Class User
 */
class LoginModel extends Model
{

    public function SignInfo($userInfo){
        session('sys_user_id',$userInfo['sys_user_id']);
        session('username',$userInfo['username']);
        session('group_id',$userInfo['group_id']);
    }

    public function SignOut(){
        session('sys_user_id',null);
        session('username',null);
        session('group_id',null);
    }

}