<?php
namespace app\admin\model;
use think\Db;
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
    public function note($type,$desc,$userId=0){
        $sys_user_id = $userId;
        if($userId == 0)
            $sys_user_info = session('sys_user');

        if( empty($sys_user_info) || empty($sys_user_info['sys_user_id']) ){//未登陆非法操作
            //强制退出
            $loginModel = model('Login');
            $loginModel->signOut();
            return false;
        }
        $sys_user_id = $sys_user_info['sys_user_id'];
        $data = [
            'sys_user_id' => $sys_user_id,
            'type'  =>  $type,
            'description'  =>  $desc,
            'add_time' => time(),
            'add_ip'   => Request()->ip(),
        ];
        if( Db::table($this->getTable())->insert($data) === false ){
            return false;
        }
        return true;
    }
}