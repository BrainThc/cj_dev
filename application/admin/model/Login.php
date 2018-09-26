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
        $sysData['login_count'] = $userInfo['login_count'];
        $sysData['last_time'] = date('Y-m-d H:i:s',$userInfo['last_time']);
        $sysData['last_ip'] = $userInfo['last_ip'];
        //获取权限信息
        $sysUserGroup = model('SysUserGroup');
        $groupValue = Db::table($sysUserGroup->getTable())->field('value,group_name,status')->where('group_id',$userInfo['group_id'])->find();
        $is_super = false;
        if( empty($groupValue) ){
            $sysData['sys_user_power'] = [];
        }else {
            $sysData['group_name'] = $groupValue['group_name'];
            $sysData['group_status'] = $groupValue['status'];
            if (SysUserGroupModel::SUPER_STATUS == $groupValue['status']) {
                $is_super = true;
            }
            $groupValue = explode(',', $groupValue['value']);
            $sysData['sys_user_power'] = $groupValue;
        }
        $sysData['is_super'] = $is_super;
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