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
        $sysData['sys_user_id'] = $userInfo['sys_user_id'];
        $sysData['username'] = $userInfo['username'];
        $sysData['group_id'] = $userInfo['group_id'];
        //获取权限信息
        $sysUserGroup = model('SysUserGroup');
        $groupValue = Db::table($sysUserGroup->getTable())->field('value,group_name,status')->where('group_id',$userInfo['group_id'])->find();
        $sysData['group_name'] = $groupValue['group_name'];
        $sysData['group_status'] = $groupValue['status'];
        $is_super = false;
        if(SysUserGroupModel::SUPER_STATUS == $groupValue['status']){
            $is_super = true;
        }
        $sysData['is_super'] =$is_super;
        if( empty($groupValue) ){
            $groupValue = [];
        }else{
            $groupValue = explode(',',$groupValue['value']);
        }
        $sysData['sys_user_power'] =$groupValue;
        session('sys_user',$sysData);
        if( $logModel->note(LogModel::LOGIN,'用户登陆') === false ){
            $this->signOut();
            return false;
        }
        return true;
    }

    public function signOut(){
        session('sys_user',null);
    }

}