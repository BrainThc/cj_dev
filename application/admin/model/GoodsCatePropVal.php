<?php
namespace app\admin\model;
use think\Db;
use think\Model;
/**
 * 分类属性model
 * Class User
 */
class GoodsCatePropVal extends Model
{

    protected $name = 'goods_category_prop_val';
    protected $pk = 'prop_val_id';

    const VAL_TYPE_TEXT = 0;
    const VAL_TYPE_COLOR = 1;

    //属性值类型
    public static $map_type = array(
        self::VAL_TYPE_TEXT => array(
            'name' => '文字'
        ),
        self::VAL_TYPE_COLOR => array(
            'name' => '颜色'
        )
    );
}