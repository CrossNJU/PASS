<?php

/**
 * Created by PhpStorm.
 * User: raychen
 * Date: 16/1/30
 * Time: 20:06
 */
namespace Home\Model;
use Think\Model;

class CourseModel extends Model
{
    protected $fields = array(
        'number',
        'name',
        'teacher',
        'depict',
        'selected',
        '_type'=>array(
            'number' => 'varchar',
            'name' => 'varchar',
            'teacher' => 'varchar',
            'depict' => 'text',
            'selected' => 'int',
        )
    );
    protected $pk = 'number';

}