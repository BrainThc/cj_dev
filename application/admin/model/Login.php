<?php
namespace app\admin\model;
use app\admin\model\Log as LogModel;
use app\admin\model\SysUserGroup as SysUserGroupModel;
use think\Model;
use think\Db;

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
        //获取权限信息
        $sysUserGroup = model('SysUserGroup');
        $groupValue = Db::table($sysUserGroup->getTable())->field('value')->where('group_id',$userInfo['group_id'])->find();
        if( empty($groupValue) ){
            $groupValue = [];
        }else{
            $groupValue = explode(',',$groupValue['value']);
        }
        session('sys_user_power',$groupValue);
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
        session('sys_user_power',null);
    }

}