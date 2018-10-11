<?php
namespace app\admin\controller;
use app\admin\model\SysUser as SysUserModel;
use app\admin\model\SysUserGroup as GroupModel;
use app\admin\model\Log as LogModel;
use think\Db;
use think\Exception;

/**
 * Class SysUser
 * @package app\admin\controller
 */

class Sysuser extends Base
{

    public function _initialize()
    {
        parent::_initialize();
        $this->sysUserModel = model('SysUser');
    }

    //列表主页
    public function index()
    {
        //获取所有权限组
        $groupModel = model('SysUserGroup');
        $groupList = Db::table($groupModel->getTable())->select();
        $this->assign('groupList',$groupList);
        $this->assign('statusList',SysUserModel::$map_status);//所有的用户状态类型
        return $this->fetch();
    }

    public function get_user_list(){
        $where = [];
        //id筛选
        $sys_user_id = input('post.sys_user_id','');
        if( $sys_user_id != '' ){
            $where['sys_user_id'] = ['=',$sys_user_id];
        }
        //账号筛选
        $keyword = input('post.keyword','');
        if( $keyword != '' ){
            $where['username'] = ['like',"%{$keyword}%"];
        }
        //权限组筛选
        $group_id = input('post.group_id',0);
        if( intval($group_id) > 0 ){
            $where['group_id'] = $group_id;
        }
        //用户状态筛选
        $status = input('post.status','');
        if( !empty($status) && isset(SysUserModel::$map_status[$status]) ){
            $where['status'] = SysUserModel::$map_status[$status]['value'];
        }
        $userList = Db::table($this->sysUserModel->getTable())
            ->where($where)
            ->order('sys_user_id','asc')
            ->paginate(15);

        if( !empty($userList) ){
            foreach( $userList as $k => $v ){
                $v['last_date'] = date('Y-m-d H:i:s',$v['last_time']);
                $v['statusType'] = SysUserModel::$map_status[$v['status']]['desc'];
                $userList[$k] = $v;
            }
        }
        $info['list'] = $userList;
        //分页工具
        $page = $userList->render();
        $info['page'] = empty($page) ? '' : $page;
        returnJson(true,'success',$info);
    }

    //刷新用户权限
    public function updateLoginCache(){
        $userInfo = Db::table($this->sysUserModel->getTable())
            ->where('sys_user_id',$this->sysUserId)
            ->find();
        $loginModel = model('Login');
        if( $loginModel->signInfo($userInfo) === false )
            $this->error('账号异常~~~',\think\Url::build('admin/index/index'),'',1);

        $this->redirect('admin/index/index');
        exit;
    }

    //添加管理员页面
    public function add(){
        //获取所有权限组
        $groupModel = model('SysUserGroup');
        $groupList = Db::table($groupModel->getTable())->where('status != 2')->select();
        $this->assign('groupList',$groupList);
        return $this->fetch();
    }

    /**
     * 添加管理员
     */
    public function create_user(){
        $data = input('post.');
        try{
            $insertData = [];
            if( empty($data['username']) )
                throw new Exception('账号不能为空');

            $insertData['username'] = trim($data['username']);
            if( empty($data['password']) )
                throw new Exception('密码不能为空');

            //检查账号是否重复
            $checkState = Db::table($this->sysUserModel->getTable())
            ->where('username',$insertData['username'])
            ->find();
            if( !empty($checkState) )
                throw new Exception('账号已存在');

            $insertData['password'] = trim($data['password']);
            $insertData['keyCode'] = $this->sysUserModel->setKeyCode();//获取秘钥
            $insertData['password'] = $this->sysUserModel->encryptPwd($insertData['password'],$insertData['keyCode']);//加密处理
            $insertData['group_id'] = empty($data['group_id']) ? 0 : intval($data['group_id']);
            //检查权限组是否存在
            if( !empty($insertData['group_id']) ){
                $groupModel = model('SysUserGroup');
                $checkState = Db::table($groupModel->getTable())
                    ->where('group_id',$insertData['group_id'])
                    ->find();
                if( empty($checkState) )
                    throw new Exception('权限组不存在');

            }
            $insertData['desc'] = empty($data['desc']) ? '' : trim($data['desc']);

            $insertData['reg_ip'] = Request()->ip();
            $insertData['reg_time'] = time();

            Db::startTrans();
            if( Db::table($this->sysUserModel->getTable())->insert($insertData) === false )
                throw new Exception('密码不能为空');

            //添加日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::INSERT,'添加管理员：'.$insertData['username']) === false )
                throw new Exception('网络错误，操作失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'添加成功');
    }

    public function edit(){
        $id = intval(input('param.id',0));
        if( $id <= 0 ){
            noPermission();
            url();
        }
        $info = Db::table($this->sysUserModel->getTable())
            ->field('sys_user_id,username,group_id,status')
            ->where('sys_user_id',$id)
            ->find();

        if(empty($info)){
            noPermission();
            url();
        }
        $groupModel = model('SysUserGroup');
        //检查是否超级管理员
        $show_group_box = true;
        if( $groupModel->checkSuperGroup($info['group_id']) === true ){
            $show_group_box = false;
            //检查是否超级管理员自己
            if( $this->sysUserId != $info['sys_user_id'] ){
                noPermission();
            }
        }
        $this->assign('show_group_box',$show_group_box);

        $tip_show = false;
        if( $info['status'] == SysUserModel::USER_DELETE ){
            $tip_show = true;
        }
        $this->assign('tipShow',$tip_show);
        $this->assign('info',$info);
        //获取所有权限组
        $groupList = Db::table($groupModel->getTable())->where('status != 2')->select();
        $this->assign('groupList',$groupList);
        return $this->fetch();
    }

    /**
     * 更改管理员信息
     */
    public function update_user(){
        $data = input('post.');
        try{
            $updateData = [];
            if( empty($data['sys_user_id']) )
                throw new Exception('参数错误');

            //检查用户是否存在
            $info = Db::table($this->sysUserModel->getTable())
                ->where('sys_user_id',$data['sys_user_id'])
                ->find();

            if( empty($info) )
                throw new Exception('参数错误');

            //更改密码
            if( !empty($data['password']) ){
                $updateData['password'] = trim($data['password']);
                $updateData['keyCode'] = $this->sysUserModel->setKeyCode();//获取秘钥
                $updateData ['password'] = $this->sysUserModel->encryptPwd($updateData['password'],$updateData['keyCode']);//加密处理
                //查看是否异常用户
                if( $info['status'] == SysUserModel::USER_DELETE ){
                    $updateData['status'] = 1;
                }
            }

            //更新权限组
            if( !empty($data['group_id']) ){
                $updateData['group_id'] = intval($data['group_id']);
                //检查权限组是否存在
                $groupModel = model('SysUserGroup');
                $checkState = Db::table($groupModel->getTable())
                    ->where('group_id',$updateData['group_id'])
                    ->find();

                if( empty($checkState) )
                    throw new Exception('权限组不存在');

            }
            Db::startTrans();
            $updateState = Db::table($this->sysUserModel->getTable())
                ->where('sys_user_id',$data['sys_user_id'])
                ->update($updateData);
            if( empty($updateState) )
                throw new Exception('网络错误,用户信息异常');

            //日志记录
            $logModel = model('Log');
            if( $logModel->note(LogModel::UPDATES,"编辑管理员id: {$data['sys_user_id']} 信息") === false )
                throw new Exception('网络错误，操作失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'保存成功');
    }

    //检查是否超级管理员
    public function checkSuper($group_id){
        //获取所有权限组
        $groupModel = model('SysUserGroup');
        $groupInfo = Db::table($groupModel->getTable())->where('group_id',$group_id)->find();
        if( !empty($groupInfo) && $groupInfo['status'] == GroupModel::SUPER_STATUS ){
            return true;
        }
        return false;
    }

    /**
    * 禁用 / 恢复 管理员
    */
    public function disable_user(){
        $data = input('post.');
        try{
            if( empty($data['sys_user_id']) || empty($data['key']) )
                throw new Exception('参数错误');

            $user_id = intval($data['sys_user_id']);
            if( $user_id <= 0 )
                throw new Exception('参数错误');

            //检查用户是否存在
            $info = Db::table($this->sysUserModel->getTable())
                ->where('sys_user_id',$user_id)
                ->find();
            if( empty($info ) )
                throw new Exception('参数错误');

            $key = trim($data['key']);
            if( $key != __COMPANYKEY__ )
                throw new Exception('秘钥错误');

            if( $this->checkSuper($info['group_id']) === true )
                throw new Exception('此账号不能禁用');

            $updateData['status'] =$info['status'] == 1 ? 2 : 1;
            Db::startTrans();
            $updateState = Db::table($this->sysUserModel->getTable())
                ->where('sys_user_id',$user_id)
                ->update($updateData);
            if( empty($updateState) )
                throw new Exception('网络错误,操作失败');

            //日志记录
            $logModel = model('Log');
            if( $logModel->note(LogModel::UPDATES,'设置管理员账号：'.$info['username'].' 状态为 ：'.SysUserModel::$map_status[$updateData['status']]['desc']) === false )
                throw new Exception('网络错误，操作失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'操作成功');
    }

    /**
     * 注销 管理员
     */
    public function deleted_user(){
        $data = input('post.');
        try{
            if( empty($data['sys_user_id']) || empty($data['key']) )
                throw new Exception('参数错误');

            $user_id = intval($data['sys_user_id']);
            if( $user_id <= 0 )
                throw new Exception('参数错误');

            //检查用户是否存在
            $info = Db::table($this->sysUserModel->getTable())
                ->where('sys_user_id',$user_id)
                ->find();
            if( empty($info) )
                throw new Exception('参数错误');

            $key = trim($data['key']);
            if( $key != __COMPANYKEY__ )
                throw new Exception('秘钥错误');

            if( $this->checkSuper($info['group_id']) === true )
                throw new Exception('此账号不能注销');

            $updateData['status'] = SysUserModel::USER_DELETE;
            //注销清空秘钥key
            $updateData['keyCode'] = '';
            Db::startTrans();
            $updateState = Db::table($this->sysUserModel->getTable())
                ->where('sys_user_id',$user_id)
                ->update($updateData);
            if( empty($updateState) )
                throw new Exception('网络错误,操作失败');

            //日志记录
            $logModel = model('Log');
            if( $logModel->note(LogModel::UPDATES,'注销管理员账号：'.$info['username']) === false )
                throw new Exception('网络错误，操作失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'操作成功');
    }

}
