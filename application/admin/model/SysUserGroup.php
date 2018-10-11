<?php
namespace app\admin\model;
use think\Db;
use think\Model;

/**
 * 权限组model
 * Class Powergroup
 */
class SysUserGroup extends Model
{
    protected $name = 'sys_user_group';
    protected $pk = 'group_id';

    const DISABLE_STATUS = 0;//禁用
    const NORMAL_STATUS = 1;//正常
    const SUPER_STATUS = 2;//超级管理员status值

    //权限组状态映射
    public static $map_status = array(
        self::DISABLE_STATUS    => '禁用',
        self::NORMAL_STATUS     => '正常',
        self::SUPER_STATUS      => '正常'
    );

    //检查是否超级管理员
    public function checkSuperGroup($group_id){
        //获取所有权限组
        $groupInfo = Db::table($this->getTable())
            ->field('status')
            ->where('group_id',$group_id)
            ->find();
        if( empty($groupInfo) ){
            return false;
        }
        if( $groupInfo['status'] == self::SUPER_STATUS ){
            return true;
        }
        return false;
    }

    /**
     * 过滤菜单power参数
     * @param $menuList         菜单参数集 必须带 power 唯一参数
     * @param array $powerArr   已有power限参数集
     * @param string $where     条件设置
     * @return array            已过滤的power参数集
     */
    public function filterPowerData($menuList,$powerArr=[],$where='change'){
        if( !empty($menuList) ){
            foreach( $menuList as $k => $v ){
                $powerArr[] = $v['power'];
                if( !empty($v['child']) && is_array($v['child']) ){
                    $powerArr = $this->filterPowerData($v['child'],$powerArr);
                }
            }
        }
        return $powerArr;
    }
}