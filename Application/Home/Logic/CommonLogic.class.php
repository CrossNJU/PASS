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
        $url_base = C('URL_BASE');

        $section = $word->createSection();
        $section->addTitle('Comments && marks:');
        $section->addTextBreak(2);
        $section->addText($comments);
        $section->addTextBreak(2);
        $section->addText($mark);

        $output = \PHPWord_IOFactory::createWriter($word,'Word2007');
        $output->save($url_base.'assignments/'.$student_id.'/'.$assignment_id.'/modify.doc');

        return 1;
    }

    public function isEnded($time){
        $now = date("y-m-d h:i:s");
        if(strtotime($time)<strtotime($now)) return true;
        return false;
    }

    public function get_display_number($number, $type){
        if ($type == 1){//课程
            return 'PC'.$this->get_string($number);
        }else if ($type == 2){//作业
            return 'PA'.$this->get_string($number);
        }
        return "NULL";
    }

    private function get_string($p){
        $ret = '';
        $len = 0;
        $ps = $p;
        while($ps>=1){
            $len++;
            $ps/=10;
        }
        for($i=0;$i<4-$len;$i++) $ret.='0';
        $ret.=$p;
        return $ret;
    }

    public function addToZip($assignment_id){
        $assignment_dis_model = M('Assignmentdis');
        $zip = new \ZipArchive();
        $url_base = C('URL_BASE');
        $url = $url_base.'downloads/'.$assignment_id.'.zip';
        $zip->open($url,\ZIPARCHIVE::CREATE | \ZIPARCHIVE::OVERWRITE);

        $assignments = $assignment_dis_model->where("assNumber = '$assignment_id'")
            ->select();
        foreach ($assignments as $assignment) {
            if($assignment['isSubmitted'] == 1){
                $zip->addFile($url_base.$assignment['url'].$assignment['savename'],'assignments/'.$assignment['stdNumber'].'/'.$assignment['savename']);
            }
            if($assignment['isExamined'] == 1){
                $zip->addFile($url_base.$assignment['url'].'modify.doc','assignments/'.$assignment['stdNumber'].'/modify.doc');
            }
        }
        $zip->close();
        unset($zip);
        return $url;
    }

}