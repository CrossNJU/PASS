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
        'submited',
        'examined',
        'startTime',
        'endTime',
        'belonged',
        'teacher',
        '_type'=>array(
            'number' => 'varchar',
            'requi' => 'text',
            'title' => 'varchar',
            'submited' => 'int',
            'examined' => 'int',
            'startTime' => 'date',
            'endTime' => 'date',
            'belonged' => 'varchar',
            'teacher' => 'varchar',
        )
    );
    protected $pk = 'number';
}