<?php

/**
 * Created by PhpStorm.
 * User: raychen
 * Date: 16/1/30
 * Time: 20:05
 */
namespace Home\Model;
use Think\Model;

class StudentModel extends Model
{
    protected $fields=array(
        'number',
        'password',
        'email',
        'name',
        'id',
        'acadamy',
        'speciality',
        'grade',
        'permission',
        '_type' => array(
            'number' => 'varchar',
            'password' => 'varchar',
            'email' => 'varchar',
            'name' => 'varchar',
            'id' => 'varchar',
            'acadamy' => 'varchar',
            'speciality' => 'varchar',
            'grade' => 'int',
            'permission' => 'tinyint',
        )
    );
    protected $pk = 'number';
}