<?php
namespace app\common\model;
use think\Db;
use think\Model;
/**
 * 商品model
 * Class User
 */
class Goods extends Model
{

    protected $name = 'goods';
    protected $pk = 'goods_id';

    const SALES_ON = 1;
    const SALES_OFF = 2;

    public static $map_sales_status = array(
        self::SALES_ON => array(
            'desc' => '已上架'
        ),
        self::SALES_OFF => array(
            'desc' => '已下架'
        )
    );

    const VERIFY_SUCCESS = 1;
    const VERIFY_FAIL = 2;


    public static $map_verfiy_status = array(
        self::VERIFY_SUCCESS => array(
            'desc' => '已上架'
        ),
        self::VERIFY_FAIL => array(
            'desc' => '已下架'
        )
    );

}