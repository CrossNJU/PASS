<?php
/**
 * Created by PhpStorm.
 * User: raychen
 * Date: 16/3/27
 * Time: 00:20
 */

namespace Home\Model;


use Think\Model;

class FeedbackModel extends Model
{

    protected $fields=array(
        'number',
        'name',
        'permission',
        'content',
        'add_time',
        '_type' => array(
            'number' => 'varchar',
            'permission' => 'tinyint',
            'name' => 'varchar',
            'add_time' => 'date',
            'content' => 'text',
        )
    );

    protected $pk = 'number';

    //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间])
    protected $_validate = array(
        array('number','require','账号为空!'),
        array('permission',array(1,2,3),'值的范围不正确!',2,'in'),
        array('name','','姓名格式错误!',0,'/^[\x{4e00}-\x{9fa5}]{2,10}$/u',1),
    );

}