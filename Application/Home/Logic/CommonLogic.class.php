<?php
/**
 * Created by PhpStorm.
 * User: raychen
 * Date: 16/2/19
 * Time: 18:59
 */

namespace Home\Logic;
use Think\Model;
use PHPWord;

class CommonLogic
{

    public function save_as_word($comments,$mark,$student_id,$assignment_id){
        vendor('PHPWord.PHPWord');
        $word = new PHPWord();

        $section = $word->createSection();
        $section->addTitle('Comments && marks:');
        $section->addTextBreak(2);
        $section->addText($comments);
        $section->addTextBreak(2);
        $section->addText($mark);

        $output = \PHPWord_IOFactory::createWriter($word,'Word2007');
        $output->save('./Public/uploads/'.$student_id.'/'.$assignment_id.'/modify.doc');

        return 1;
    }

    public function isEnded($time){
        $now = date("y-m-d h:i:s");
        if(strtotime($time)<strtotime($now)) return true;
        return false;
    }

}