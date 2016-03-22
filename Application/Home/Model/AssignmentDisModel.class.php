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
        'saveName',
        'saveType',
        'isWarning',
        '_type'=>array(
            'stdNumber' => 'varchar',
            'assNumber' => 'varchar',
            'cNumber' => 'varchar',
            'mark' => 'tinyint',
            'comm' => 'text',
            'url' => 'varchar',
            'isSubmitted' => 'tinyint',
            'isExamined' => 'tinyint',
            'submitTime' => 'date',
            'submitName' => 'varchar',
            'saveName' => 'varchar',
            'saveType' => 'varchar',
            'isWarning' => 'tinyint',
        )
    );
    protected $_validate = array(
        array('mark','','分数格式有误!',2,'/^(([0-9]{1,2})?|100)$/',2),
        array('isSubmitted',array(0,1),'是否已提交值的范围不正确!',2,'in'),
        array('isExamined',array(0,1),'是否已批阅值的范围不正确!',2,'in'),
        array('isWarning',array(0,1),'是否重新提交值的范围不正确!',2,'in'),
    );
}