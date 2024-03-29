<?php
namespace app\admin\controller;
use think\Controller;
use think\Exception;

class Login extends Controller
{

    //登录主页
    public function index()
    {
        $userId = session('sys_user');
        if( !empty($userId) ){
            $this->redirect('admin/index/index');
        }
        return $this->fetch();
    }

    //登录接口
    public function signIn(){
        $data = input('post.');
        $sysUserModel = model('SysUser');
        $loginModel = model('Login');
        try{
            if( empty($data) || empty($data['username']) || empty($data['password']) )
                throw new Exception('账号和密码不能为空');

            if( empty($data['verifyCode']) )
                throw new Exception('请填写验证码');

            $username = trim($data['username']);
            $password = trim($data['password']);
            //用户检查
            $where['username'] = ['=',$username];
            $where['status'] = ['>',0];
            $userInfo = $sysUserModel->where($where)->find();
            if( empty($userInfo) )
                throw new Exception('用户不存在');

            //检查密码
            if( $sysUserModel->encryptPwd($password,$userInfo['keyCode']) != $userInfo['password'] )
                throw new Exception('密码错误');

            if( captcha_check($data['verifyCode']) === false )
                throw new Exception('验证码错误');

            //检查账号状态
            if( $sysUserModel::$map_status[$userInfo['status']]['value'] != $sysUserModel::USER_NORMAL )
                throw new Exception(    '账号已被禁用');

            $loginModel->startTrans();
            //配置登录信息
            if( $loginModel->signInfo($userInfo) === false )
                throw new Exception('网络错误，登录信息记录失败');

            //更新用户信息
            $login_count = $userInfo['login_count'];
            $login_count++;
            $data = [
                'login_count'   => $login_count,
                'last_ip'       => Request()->ip(),
                'last_time'     => time()
            ];
            $updateWhere['sys_user_id'] = $userInfo['sys_user_id'];
            $updateState = $sysUserModel->where($updateWhere)->update($data);
            if( empty($updateState) )
                throw new Exception('网络错误,用户信息异常');

            $loginModel->commit();
        }catch( Exception $e ){
            $loginModel->rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'登录成功');
    }

    /**
     * 退出
     */
    public function signOut(){
        $loginModel = model('Login');
        $loginModel->signOut();
        $userId = session('sys_user_id');
        if( empty($userId) ){
            $this->success('退出成功，正在跳转~~~',url('login/index'),'',1);
        }else{
            $this->error('操作失败，正在返回~~~',url('index/index'),'',1);
        }
    }

    //整个系统初始化
    public function reset(){
        $appid = input('get.aid','');
        $appsecret = input('get.setkey','');
        if( empty($appid) || empty($appsecret) ){
            noPermission();
        }

        $keys = md5(__COMPANYKEY__.'reset_*a');
        if( $keys == $appid && sha1($keys) == $appsecret ){
            //执行操作
            echo '已重置';
            exit;
        }
    }

}
