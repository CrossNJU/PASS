<?php

/**
 * Created by PhpStorm.
 * User: raychen
 * Date: 16/1/30
 * Time: 20:07
 */
namespace Home\Model;
use Think\Model;

class AssignmentdisModel extends Model
{
    protected $fields = array(
        'stdNumber',
        'assNumber',
        'cNumber',
        'mark',
        'comm',
        'url',
        'isSubmitted',
        'isExamined',
        'submitTime',
        'submitName',
        '_type'=>array(
            'stdNumber' => 'varchar',
            'assNumber' => 'varchar',
            'cNumber' => 'varchar',
            'mark' => 'int',
            'comm' => 'text',
            'url' => 'varchar',
            'isSubmitted' => 'tinyint',
            'isExamined' => 'tinyint',
            'submitTime' => 'date',
            'submitName' => 'varchar',
        )
    );
}