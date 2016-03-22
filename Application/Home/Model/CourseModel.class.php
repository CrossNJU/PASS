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
        'number_display',
        'title',
        'teacher',
        'depict',
        'selected',
        'time',
        'assignments',
        'students',
        'create_time',
        '_autoinc' => true,
        '_type'=>array(
            'number' => 'int',
            'number_display' => 'varchar',
            'title' => 'varchar',
            'teacher' => 'varchar',
            'depict' => 'text',
            'selected' => 'int',
            'time' => 'varchar',
            'assignments' => 'int',
            'students' => 'int',
            'create_time' => 'date'
        )
    );
    protected $pk = 'number';

    protected $_validate = array(
        array('students','number','学生人数格式有误!'),
        array('title','require','请填写课程标题!'),
    );
}