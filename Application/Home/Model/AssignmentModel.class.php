<?php

/**
 * Created by PhpStorm.
 * User: raychen
 * Date: 16/1/30
 * Time: 20:06
 */
namespace Home\Model;
use Think\Model;

class AssignmentModel extends Model
{
    protected $fields = array(
        'number',
        'requi',
        'title',
        'submitted',
        'examined',
        'startTime',
        'endTime',
        'course',
        'teacher',
        '_autoinc' => true,
        '_type'=>array(
            'number' => 'int',
            'requi' => 'text',
            'title' => 'varchar',
            'submitted' => 'int',
            'examined' => 'int',
            'startTime' => 'date',
            'endTime' => 'date',
            'course' => 'varchar',
            'teacher' => 'varchar',
        )
    );
    protected $pk = 'number';
}