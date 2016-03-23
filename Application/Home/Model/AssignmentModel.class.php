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
        'modify_time',
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
            'modify_time' => 'date'
        )
    );
    protected $pk = 'number';
    protected $_validate = array(
        array('requi','require','请输入作业要求!'),
        array('title','require','请输入作业标题!'),
    );
}