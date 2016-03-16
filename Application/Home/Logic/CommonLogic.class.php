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
            if($assignment['issubmitted'] == 1){
                $zip->addFile($url_base.$assignment['url'].$assignment['savename'],'assignments/'.$assignment['stdnumber'].'/'.$assignment['savename']);
            }
            if($assignment['isexamined'] == 1){
                $zip->addFile($url_base.$assignment['url'].'modify.doc','assignments/'.$assignment['stdnumber'].'/modify.doc');
            }
        }
        $zip->close();
        unset($zip);
        return $url;
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

    public function getMessage($res,$type){
        $ret = array();
        switch($type){
            case 'suc':$ret['type'] = 'success';break;
            case 'err':$ret['type'] = 'danger';break;
            case 'war':$ret['type'] = 'warning';break;
            default:$ret['type'] = '';
        }
        if($ret['type'] == ''){
            $ret['res'] = '';
            return $ret;
        }else{
            switch ($res){
                case "reg-suc":$ret['res'] = '注册成功!';break;
                case "reset-suc":$ret['res'] = '重置成功!';break;
                case "login-war":$ret['res'] = '尚未登录!';break;
                case "upload-suc":$ret['res'] = '上传成功!';break;
                case "save-suc":$ret['res'] = '保存成功!';break;
                case "del-suc":$ret['res'] = '发布成功!';break;
                case "add-stu-suc":$ret['res'] = '增加学生成功!';break;
                case "mod-stu-suc":$ret['res'] = '修改学生成功!';break;
                case "add-tea-suc":$ret['res'] = '增加老师成功!';break;
                case "mod-tea-suc":$ret['res'] = '修改老师成功!';break;
                case "add-cou-suc":$ret['res'] = '增加课程成功!';break;
                case "mod-cou-suc":$ret['res'] = '修改课程成功!';break;
                case "modify-suc":$ret['res'] = '批阅完成!';break;
                default: $ret['res'] = ''; $ret['type'] = '';
            }
            return $ret;
        }
    }

}