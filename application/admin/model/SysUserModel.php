<?php
namespace app\admin\model;
use think\Db;
use think\Model;
/**
 * 管理员账号model
 * Class User
 */
class SysUserModel extends Model{

    protected $table = 'sys_user';
    protected $pk = 'sys_user_id';

    public $getInfo = null;

    const USER_DELETE = 0;
    const USER_NORMAL= 1;
    const USER_DISABLE = 2;

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

    /**
     * 检查用户吃否存在
     * @param string $username      用户名
     * @param bool $isGet           是否提取用户信息 暂存 $this->getInfo
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function issetUser($username='',$isGet=false){
        if( empty($username) )
            return false;

        $userInfo = Db::name($this->getTable())
            ->where('username',$username)
            ->find();

        if($isGet)
            $this->getInfo = $userInfo;

        return !empty($userInfo);
    }

    /**
     * 后台管理员信息更新操作
     * @param int $sysUserId        管理员id
     * @param $data                 更新内容参数 array()
     * @return bool|int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function updateUser($sysUserId=0,$data){
        if( $sysUserId <= 0 ){
            return false;
        }
        return Db::name($this->getTable())->where($this->getPk(),$sysUserId)->update($data);
    }




}

?>