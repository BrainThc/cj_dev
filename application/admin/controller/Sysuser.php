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
        $where = [];
        //id筛选
        $sys_user_id = input('keyword','');
        if( $sys_user_id != '' ){
            $where['sys_user_id'] = ['=',$sys_user_id];
        }
        //账号筛选
        $keyword = input('keyword','');
        if( $keyword != '' ){
            $where['username'] = ['like',"%{$keyword}%"];
        }
        //权限组筛选
        $group_id = input('group_id',0);
        if( intval($group_id) > 0 ){
            $where['group_id'] = $group_id;
        }
        //用户状态筛选
        $status = input('status','');
        if( isset(SysUserModel::$map_status[$status]) ){
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
        $page = $userList->render();
        $this->assign('list',$userList);
        $this->assign('page',$page);
        return $this->fetch();
    }

    //刷新用户权限
    public function updateLoginCache(){
        $userInfo = Db::table($this->sysUserModel->getTable())
            ->where('sys_user_id',$this->sysUserId)
            ->find();
        $loginModel = model('Login');
        if( $loginModel->signInfo($userInfo) === false )
            $this->error('刷新状态失败~~~',\think\Url::build('admin/index/index'),'',1);

        $this->redirect('admin/index/index');
        exit;
    }

    //添加管理员页面
    public function add(){

        $this->fetch();
    }

    /**
     * 添加管理员
     */
    public function create_user(){
        $data = input('.post');
        try{
            $insertData = [];
            if( empty($data['username']) )
                throw new Exception('账号不能为空');

            $insertData['username'] = trim($data['username']);
            if( empty($data['pwd']) )
                throw new Exception('密码不能为空');

            //检查账号是否重复
            $checkState = Db::table($this->sysUserModel->getTable())
            ->where('username',$insertData['username'])
            ->find();
            if( !empty($checkState) )
                throw new Exception('账号已存在');

            $insertData['password'] = trim($data['password']);
            $keyCode = $this->sysUserModel->setKeyCode();//获取秘钥
            $insertData['password'] = $this->encryptPwd($insertData['password'],$keyCode);//加密处理
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

    /**
     * 更改管理员信息
     */
    public function update_user(){
        $data = input('.post');
        try{
            $updateData = [];
            if( empty($data['sys_user_id']) ){
                throw new Exception('参数错误');
            }
            if( !empty($data['username']) ){
                $updateData['username'] = trim($data['username']);
                $where['username'] = ['=',$updateData['username']];
                $where['sys_user_id'] = ['!=',$updateData['username']];
                //检查账号是否重复
                $checkState = Db::table($this->sysUserModel->getTable())
                    ->where($where)
                    ->find();
                if( !empty($checkState) )
                    throw new Exception('账号已存在');
            }

            //更改密码
            if( !empty($data['password']) ){
                $updateData['password'] = trim($data['password']);
                $keyCode = $this->sysUserModel->setKeyCode();//获取秘钥
            }
            $updateData ['password'] = $this->encryptPwd($updateData['password'],$keyCode);//加密处理

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
            if( $logModel->note(LogModel::UPDATES,'编辑管理员信息：'.$updateState['username']) === false )
                throw new Exception('网络错误，操作失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'添加成功');
    }

    /**
    * 禁用管理员
    */
    public function disable_user(){
        $data = input('.post');
        try{
            if( empty($data['sys_user_id']) || empty($data['key']) ){
                throw new Exception('参数错误');
            }
            $key = trim($data['key']);
            if( $key != __COMPANYKEY__ ){
                throw new Exception('秘钥错误');
            }
            $updateData['status'] = SysUserModel::USER_DISABLE;
            Db::startTrans();
            $updateState = Db::table($this->sysUserModel->getTable())
                ->where('sys_user_id',$data['sys_user_id'])
                ->update($updateData);
            if( empty($updateState) )
                throw new Exception('网络错误,用户信息异常');

            //日志记录
            $logModel = model('Log');
            if( $logModel->note(LogModel::UPDATES,'编辑管理员管理员：'.$updateState['username']) === false )
                throw new Exception('网络错误，操作失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'添加成功');
    }

}
