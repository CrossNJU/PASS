<?php

/**
 * Created by PhpStorm.
 * User: raychen
 * Date: 16/1/30
 * Time: 20:07
 */
namespace Home\Model;
use Think\Model;

class AssignmentDisModel extends Model
{
    protected $fields = array(
        'stdNumber',
        'assNumber',
        'mark',
        'comm',
        'submitted',
        'examined',
        '_type'=>array(
            'stdNumber' => 'varchar',
            'assNumber' => 'varchar',
            'mark' => 'int',
            'comm' => 'text',
            'submitted' => 'tinyint',
            'examined' => 'tinyint',
        )
    );
}