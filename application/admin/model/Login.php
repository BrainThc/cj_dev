<?php
namespace app\admin\model;
use app\admin\model\Log as LogModel;
use think\Model;

/**
 * 管理员账号model
 * Class User
 */
class Login extends Model
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