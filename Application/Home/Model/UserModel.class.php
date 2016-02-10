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
        'email',
        'permission',
        'name',
        'academy',
        'speciality',
        'grade',
        '_type' => array(
            'number' => 'varchar',
            'password' => 'varchar',
            'email' => 'varchar',
            'permission' => 'tinyint',
            'name' => 'varchar',
            'grade' => 'int',
            'academy' => 'varchar',
            'speciality' => 'varchar',
        )
    );

    protected $pk = 'number';
}