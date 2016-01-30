<?php

/**
 * Created by PhpStorm.
 * User: raychen
 * Date: 16/1/30
 * Time: 20:06
 */
namespace Home\Model;
use Think\Model;

class TeacherModel extends Model
{
    protected $fields=array(
        'ID',
        'password',
        'email',
        'name',
        'permission',
        '_type' => array(
            'ID' => 'varchar',
            'password' => 'varchar',
            'email' => 'varchar',
            'name' => 'varchar',
            'permission' => 'tinyint',
        )
    );

    protected $pk = 'ID';
}