<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\SysUserModel;
use think\Exception;

class Login extends Controller
{

    public function index()
    {
        $userId = session('sys_user_id');
        if( !empty($userId) ){
            $this->redirect('admin/index/index');
        }
        return $this->fetch();
    }

    //登录接口
    public function signIn(){
        $data = input('post.');
        $sysUserModel = model('SysUser');
        $db = $sysUserModel->getQuery();
        try{
            if( empty($data) || empty($data['username']) || empty($data['password']) || empty($data['verifyCode']) )
                throw new Exception('账号和密码不能为空');

            $username = trim($data['username']);
            $password = trim($data['password']);
            if( $sysUserModel->issetUser($username,true) === false )
                throw new Exception('用户不存在');

            $userInfo = $sysUserModel->getInfo;
            //检查密码
            if( $sysUserModel->encryptPwd($password,$userInfo['keyCode']) != $userInfo['password'] )
                throw new Exception('密码错误');

            if( captcha_check($data['verifyCode']) === false )
                throw new Exception('验证码错误');

            //检查账号状态
            if( SysUserModel::$map_status[$userInfo['status']]['value'] != SysUserModel::USER_NORMAL )
                throw new Exception('账号已被禁用');

            $db->startTrans();
            //配置登录信息
            $loginModel = model('Login');
            if( $loginModel->signInfo($userInfo) === false )
                throw new Exception('网络错误，登录信息记录失败');

            //更新用户信息
            $request = Request();
            $userInfo['login_count']++;
            $data = [
                'login_count'   => $userInfo['login_count'],
                'last_ip'       => $request->ip(),
                'last_time'     => time(),
            ];
            if( $sysUserModel->updateUser($userInfo['sys_user_id'],$data) === false ){
                throw new Exception('网络错误,用户信息异常');
            }
            $db->commit();
        }catch( Exception $e ){
            $db->rollback();
            retrunJosn(false,$e->getMessage());
        }
        retrunJosn(true,'登录成功');
    }

    /**
     * 退出
     */
    public function signOut(){
        $loginModel = model('Login');
        $loginModel->signOut();
        $userId = session('sys_user_id');
        if( empty($userId) ){
            $this->success('退出成功，正在跳转~~~',\think\Url::build('admin/login/index'),'',1);
        }else{
            $this->success('操作失败，正在返回~~~',\think\Url::build('admin/index/index'),'',1);
        }
    }

}
