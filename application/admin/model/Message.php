<?php
namespace app\admin\model;
use think\Db;
use think\Model;
/**
 * 留言model
 * Class User
 */
class Message extends Model
{
    protected $name = 'message_list';
    protected $pk = 'id';

    //阅读状态
    const READ_STATUS = 0;
    const READED_STATUS = 1;
    //回复状态
    const REPLY_STATUS = 0;
    const REPLYED_STATUS = 1;
    //用户类型
    const USER = 0;
    const ADMIN = 1;
    /**
     * 阅读状态
     */
    public static $map_read_status = array(
        self::READ_STATUS => array(
            'name' => '未读'
        ),
        self::READED_STATUS => array(
            'name' => '已读'
        )
    );

    /**
     * 回复状态
     */
    public static $map_reply_status = array(
        self::REPLY_STATUS => array(
            'name' => '未回复'
        ),
        self::REPLYED_STATUS => array(
            'name' => '已回复'
        )
    );

    /**
     * 作者类型
     */
    public static $map_user_type = array(
        self::USER => array(
            'name' => '会员'
        ),
        self::ADMIN => array(
            'name' => '管理员'
        )
    );
}