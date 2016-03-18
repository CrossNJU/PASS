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
        'number_display',
        'requi',
        'title',
        'startTime',
        'endTime',
        'course',
        'teacher',
        'type',
        '_autoinc' => true,
        '_type'=>array(
            'number' => 'int',
            'number_display' => 'varchar',
            'requi' => 'text',
            'title' => 'varchar',
            'startTime' => 'date',
            'endTime' => 'date',
            'course' => 'varchar',
            'teacher' => 'varchar',
            'type' => 'varchar',
        )
    );
    protected $pk = 'number';
}