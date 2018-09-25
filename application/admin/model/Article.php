<?php
namespace app\admin\model;
use think\Model;
/**
 * 文章model
 * Class User
 */
class Article extends Model{

    protected $name = 'article';
    protected $pk = 'article_id';

    //阅读权限
    const READ_ADD = 0;//全部可读
    const READ_VIP = 1;//VIP用户
    const READ_ADMIN = 2;//管理员

    //阅读类型描述映射
    public static $map_readgroup = array(
        self::READ_ADD      => '所有用户',
        self::READ_VIP      => '已注册用户',
        self::READ_ADMIN    => '管理员'
    );


}

?>