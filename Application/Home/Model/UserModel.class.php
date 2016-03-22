<?php
/**
 * Created by PhpStorm.
 * User: raychen
 * Date: 16/2/6
 * Time: 21:15
 */

namespace Home\Model;
    use Think\Model;

class UserModel extends Model
{
    protected $fields=array(
        'number',
        'password',
        'phone',
        'email',
        'permission',
        'name',
        'academy',
        'speciality',
        'grade',
        'save_time',
        '_type' => array(
            'number' => 'varchar',
            'password' => 'varchar',
            'email' => 'varchar',
            'phone' => 'varchar',
            'permission' => 'tinyint',
            'name' => 'varchar',
            'grade' => 'int',
            'academy' => 'varchar',
            'speciality' => 'varchar',
            'save_time' => 'date'
        )
    );

    protected $pk = 'number';

    //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间])
    protected $_validate = array(
        array('number','require','账号为空!'),
        array('number','','用户已经存在!',0,'unique',1),
        array('password','','密码有误!',0,'/^[0-9A-Za-z]{6,20}$/',1),
        array('phone','','手机号格式有误!',0,'/^[1][358][0-9]{9}$/',1),
        array('email','email','邮箱格式有误!'),
        array('permission',array(1,2,3),'值的范围不正确!',2,'in'),
        array('name','','姓名格式错误!',0,'/^[\x{4e00}-\x{9fa5}]{2,10}$/u',1),
    );

    protected $_auto = array(
        array('password','md5',3,'function')
    );
}