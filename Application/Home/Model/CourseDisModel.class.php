<?php

/**
 * Created by PhpStorm.
 * User: raychen
 * Date: 16/1/30
 * Time: 20:07
 */
namespace Home\Model;
use Think\Model;

class CourseDisModel extends Model
{
    protected $fields = array(
        'stdNumber',
        'cNumber',
        '_type'=>array(
            'stdNumber' => 'varchar',
            'cNumber' => 'varchar'
        )
    );

}