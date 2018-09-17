<?php
namespace app\admin\model;
use think\Db;
use think\Model;
use think\Request;

/**
 * 管理员账号model
 * Class User
 */
class LoginModel extends Model
{
    public function signInfo($userInfo){
        $logModel = model('Log');
        session('sys_user_id',$userInfo['sys_user_id']);
        session('username',$userInfo['username']);
        session('group_id',$userInfo['group_id']);
        if( $logModel->note(LogModel::LOGIN,'用户登陆') === false ){
            $this->signOut();
            return false;
        }
        return true;
    }

    public function signOut(){
        session('sys_user_id',null);
        session('username',null);
        session('group_id',null);
    }

}