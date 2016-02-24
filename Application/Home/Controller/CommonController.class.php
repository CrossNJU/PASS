<?php
/**
 * Created by PhpStorm.
 * User: raychen
 * Date: 16/2/6
 * Time: 10:13
 */

namespace Home\Controller;

use Think\Controller;
use PHPMailer;

class CommonController extends Controller
{
    public function index()
    {
        $this->display('Common:Login');
    }

    public function register()//学生注册
    {
        if (isset($_POST['register'])) {
            $user_model = M('User');

            $student_id = I('post.stu_id');
            $rows = $user_model->where("number = '$student_id'")->select();
            if(count($rows)>0)
                $this->ajaxReturn(-1);//已存在用户

            $data['number'] = $student_id;
            $data['password'] = I('post.pwd');
            $data['email'] = I('post.email');
            $data['name'] = I('post.name');
            $data['academy'] = I('post.aca');
            $data['speciality'] = I('post.spe');
            $data['grade'] = I('post.grade');
            $data['permission'] = 1;
            $user_model->add($data);
        }
        $this->display('Common:Register-student');
    }

    public function login()//登录
    {
        if (isset($_POST['login'])) {
            $id = I('post.id');
            $pwd = I('post.pwd');
            $user_model = M('User');
            $row = $user_model->where("number = '$id'")->select();
            if (count($row) == 0)
                $this->ajaxReturn(-1);//用户不存在
            if ($row[0]['password'] != $pwd)
                $this->ajaxReturn(0);//密码错误
            $per = $row[0]['permission'];
//            $this->ajaxReturn($per);//登录成功

            session("user", $id);
            session("per", $per);
            switch ($per){
                case "1": $this->redirect('Student/my_course');break;
                case "2": $this->redirect('Teacher/');break;
                case "3": $this->redirect('Administer/');break;
                default: $this->ajaxReturn(-1);
            }
        }

        $this->display('Common:Login');
    }

    public function logout(){//登出
        session(null);
        $this->ajaxReturn(1);
    }

    public function find_pwd()//找回密码
    {
        $sub = '找回密码';
        $prefix = 'http://localhost/PASS/index.php/Home/Common/pwd_reset/id/';
        $address = 'cr14@software.nju.edu.cn';
        $body = $prefix;

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

        if(isset($_POST['send'])){
            $address = I('post.address');
            $user_model = M('User');
            $rows = $user_model->where("email = '$address'")
                ->select();
            $student_id = NULL;
            if(count($rows)>0){
                $student_id = $rows[0]['number'];
                $body = $body.$student_id;
            }else
//                $this->ajaxReturn(-1);//邮箱不存在
            $mail->AddAddress($address);
            $mail->MsgHTML($body);
            if($mail->Send()){
                $this->ajaxReturn(1);//发送成功
            }
            else $this->ajaxReturn($mail->ErrorInfo);//发送失败
        }

        $this->display('Common:Password-Find');
    }

    public function pwd_reset($id)//重置密码
    {
        $user = M('User');
        if (isset($_POST['rset'])) {
            $new_pwd = I('post.new_pwd');
            $row['password'] = $new_pwd;
            $row['number'] = $id;
            $user->save($row);
        }
        $this->display('Common:Password-Reset');
    }
}