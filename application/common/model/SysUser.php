<?php
namespace app\common\model;
use think\Db;
use think\Model;
/**
 * 管理员账号model
 * Class User
 */
class SysUser extends Model{

    protected $name = 'sys_user';
    protected $pk = 'sys_user_id';

    public $getInfo = null;

    const USER_DELETE = 0;//已删除
    const USER_NORMAL= 1;//正常用户
    const USER_DISABLE = 2;//禁用

    // 账号状态静态映射
    public static $map_status = array(
        self::USER_DELETE => array(
            'value' => '0',
            'desc' => '已注销',
        ),
        self::USER_NORMAL => array(
            'value' => '1',
            'desc' => '状态正常',
        ),
        self::USER_DISABLE => array(
            'value' => '2',
            'desc' => '已禁用',
        ),
    );

    /**
     * 生产用户秘钥
     * @param string $defauleKey     默认配置key
     * @return string length = 6     秘钥
     */
    public function setKeyCode($defauleKey=__COMPANYKEY__){
        $t = time();
        $keyCode = md5($defauleKey.$t);
        $keyCode=substr(str_shuffle($keyCode),mt_rand(0,strlen($keyCode)-7),6);
        return $keyCode;
    }

    /**
     * 获取密码加密串
     * @param string $pwd       密码
     * @param string $keyCode   秘钥key
     * @return string           加密串
     */
    public function encryptPwd($pwd='',$keyCode=''){
        if( empty($pwd) ){
            return '';
        }
        return md5($pwd.$keyCode);
    }

}

?>