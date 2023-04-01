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

    //文章状态
    const STATUS_FAIL = 0;//审核不通过
    const STATUS_VERIFY = 2;//审核中
    const STATUS_SUCCESS = 1;//已通过

    //文章可读状态
    const ARTICLE_SHOW = 1;
    const ARTICLE_HIDE = 0;

    //阅读类型描述映射
    public static $map_readgroup = array(
        self::READ_ADD      => '所有用户',
        self::READ_VIP      => '已注册用户',
        self::READ_ADMIN    => '管理员'
    );

    //文章状态映射
    public static $map_status = array(
        self::STATUS_FAIL   => '审核不通过',
        self::STATUS_VERIFY   => '审核中',
        self::STATUS_SUCCESS   => '已通过'
    );

    //可读状态映射
    public static $map_show = array(
        self::ARTICLE_HIDE   => '不可读',
        self::ARTICLE_SHOW   => '可读'
    );

}

?>