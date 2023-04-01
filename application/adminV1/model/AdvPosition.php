<?php
namespace app\admin\model;
use think\Db;
use think\Model;
/**
 * 广告位model
 * Class User
 */
class AdvPosition extends Model
{

    protected $name = 'adv_position';
    protected $pk = 'pos_id';

    //类型
    const IMAGE = '1';
    const VIDEO = '2';
    const Slide = '3';
    const IMAGES = '4';

    //类型映射
    public static $map_type = array(
        self::IMAGE => '单图片',
        self::VIDEO => '视频',
        self::Slide => '幻灯片',
        self::IMAGES => '多图',
    );
}