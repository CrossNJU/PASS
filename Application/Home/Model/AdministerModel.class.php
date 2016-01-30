<?php

/**
 * Created by PhpStorm.
 * User: raychen
 * Date: 16/1/30
 * Time: 20:05
 */
namespace Home\Model;
use Think\Model;

class AdministerModel extends Model
{
    protected $fields=array(
        'ID',
        'password',
        'email',
        'permission',
        '_type' => array(
            'ID' => 'varchar',
            'password' => 'varchar',
            'email' => 'varchar',
            'permission' => 'tinyint',
        )
    );
    protected $pk = 'ID';
}