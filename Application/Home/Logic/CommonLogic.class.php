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
use PHPMailer;

class CommonLogic
{

    public function save_as_word($comments,$mark,$student_id,$assignment_id){
        vendor('PHPWord.PHPWord');
        $word = new PHPWord();
        $url_base = C('URL_BASE');

        $section = $word->createSection();
        $section->addTitle(iconv('utf-8', 'GB2312//IGNORE','评语 和 分数:'));
        $section->addTextBreak(2);
        $section->addText(iconv('utf-8', 'GB2312//IGNORE', $comments));
        $section->addTextBreak(2);
        $section->addText(iconv('utf-8', 'GB2312//IGNORE', $mark));

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
        $assignment_model = M('Assignment');
        $user_logic = D('User','Logic');

        $assignment_true_title = $assignment_model->where("number = '$assignment_id'")->select()[0]['title'];

        $zip = new \ZipArchive();
        $url_base = C('URL_BASE');
        $url = $url_base.'downloads/'.$assignment_true_title.'.zip';
        $zip->open($url,\ZIPARCHIVE::CREATE | \ZIPARCHIVE::OVERWRITE);

        $assignments = $assignment_dis_model->where("assNumber = '$assignment_id'")
            ->order('submittime desc')
            ->select();
        $hasFile = false;
        foreach ($assignments as $assignment) {
            if($assignment['issubmitted'] == 1){
                $hasFile = true;
                return $url_base.$assignment['url'].$assignment['savename'];
                //$zip->addFile($url_base.$assignment['url'].$assignment['savename'],$assignment_true_title.'/'.$assignment['stdnumber'].$user_logic->get_user_name($assignment['stdnumber']).'/'.$assignment['submitname']);
            }
            if($assignment['isexamined'] == 1){
                $zip->addFile($url_base.$assignment['url'].'modify.doc',$assignment_true_title.'/'.$assignment['stdnumber'].$user_logic->get_user_name($assignment['stdnumber']).'/批阅详情.doc');
            }
        }
        $zip->close();
        unset($zip);
        if($hasFile) return $url;
        else return 'wrong';
    }

    public function sendEmail($sub, $address, $body){

        Vendor('PHPMailer.class#phpmailer');

        $mail = new PHPMailer();
        $mail->CharSet = "UTF-8";
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Port = 465;

        $mail->From = C('MAIL_FROM');
        $mail->FromName = C('MAIL_FROM_NAME');
        $mail->Host = C('MAIL_HOST');
        $mail->Username = C('MAIL_USERNAME');
        $mail->Password = C('MAIL_PASSWORD');

        $mail->Subject = $sub;
        $mail->AddAddress($address);
        $mail->MsgHTML($body);

        if($mail->Send()) return true;
        else return false;
    }

}