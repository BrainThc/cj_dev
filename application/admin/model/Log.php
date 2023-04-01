<?php
namespace app\admin\model;
use think\Model;
/**
 * 日志model
 * Class User
 */
class Log extends Model
{

    protected $name = 'sys_user_log';

    const LOGIN = 'signIn';
    const INSERT = 'insert';
    const DEL = 'del';
    const UPDATES = 'update';

    //日志类型映射
    public static $map_type = array(
        self::LOGIN     => '登陆',
        self::INSERT    => '添加操作',
        self::DEL       => '删除操作',
        self::UPDATES   => '编辑操作'
    );

    /**
     * 管理操作日志记录
     * @param $type     操作类型
     * @param $desc     操作内容
     * @return bool
     */
    public function note($type,$desc,$desc_data=array(),$userId=0){
        $sys_user_id = $userId;
        if($sys_user_id == 0) {
            $sys_user_info = session('sys_user');
            if (empty($sys_user_info) || empty($sys_user_info['sys_user_id'])) {//未登陆非法操作
                //强制退出
                $loginModel = model('Login');
                $loginModel->signOut();
                return false;
            }
            $sys_user_id = $sys_user_info['sys_user_id'];
        }
        $data = [
            'sys_user_id' => $sys_user_id,
            'type'  =>  $type,
            'description'  =>  $desc,
            'desc_data'  =>  json_encode($desc_data),
            'add_time' => time(),
            'add_ip'   => Request()->ip(),
        ];
        if( $this->insert($data) === false ){
            return false;
        }
        return true;
    }
}