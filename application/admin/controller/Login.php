<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\SysUser;
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
        $json['status'] = 0;
        $data = input('post.');
        try{
            if( empty($data) || empty($data['username']) || empty($data['password']) || empty($data['verifyCode']) )
                throw new Exception('账号和密码不能为空');

            $username = trim($data['username']);
            $password = trim($data['password']);
            $sysUserModel = model('SysUser');
            if( $sysUserModel->getUser($username,true) === false )
                throw new Exception('用户不存在');

            $userInfo = $sysUserModel->getInfo;
            //检查密码
            if( $sysUserModel->encryptPwd($password,$userInfo['keyCode']) != $userInfo['password'] )
                throw new Exception('密码错误');

            if( captcha_check($data['verifyCode']) === false )
                throw new Exception('验证码错误');

            //检查账号状态
            if( SysUser::$map_status[$userInfo['status']]['value'] != SysUser::USER_NORMAL )
                throw new Exception('账号已被禁用');

            //添加登录日志 待定

            //配置登录信息
            $loginModel = model('Login');
            $loginModel->SignInfo($userInfo);
            $json['msg'] = '登录成功';
            $json['status'] = 1;
        }catch( Exception $e ){
            $json['msg'] = $e->getMessage();
        }
        exit(json_encode($json));
    }

    /**
     * 退出
     */
    public function signOut(){
        $loginModel = model('Login');
        $loginModel->SignOut();
        $userId = session('sys_user_id');
        if( empty($userId) ){
            $this->success('退出成功，正在跳转~~~',\think\Url::build('admin/login/index'),'',1);
        }else{
            $this->success('操作失败，正在返回~~~',\think\Url::build('admin/index/index'),'',1);
        }
    }

}
