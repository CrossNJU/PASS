<?php
/**
 * Created by PhpStorm.
 * User: raychen
 * Date: 16/2/6
 * Time: 10:13
 */

namespace Home\Controller;

use Think\Controller;

class CommonController extends Controller
{
    public function index()
    {
        $this->display('Common:Login');
    }

    public function register()//.................................................................................学生注册
    {
        $this->msg = "";
        if (isset($_POST['register'])) {
            $user_model = D('User');

            $student_id = I('post.stu_id');
            $rows = $user_model->where("number = '$student_id'")->select();
            if(count($rows)>0){
                $this->msg = "用户已存在!";
                $this->type = "danger";
            }else{
                $data['number'] = $student_id;
                $data['password'] = I('post.pwd');
                $data['phone'] = I('post.phone');
                $data['email'] = I('post.email');
                $data['name'] = I('post.name');
                $data['academy'] = I('post.aca');
                $data['speciality'] = I('post.spe');
                $data['grade'] = I('post.grade');
                $data['permission'] = 1;
                if($user_model->create($data)){
                    $user_model->add();
                    $this->redirect('Common/login/res/'.'reg-suc/type/'.'suc');
                }else {
                    $this->msg = "注册失败!";
                    $this->type = "danger";
                }
            }
        }
        $this->display('Common:Register-student');
    }

    public function login($res = NULL,$type = NULL)//................................................................登录
    {
        $common_logic = D('Common','Logic');
        $user_logic = D('User','Logic');
        $this->msg = "";
        if($res!=NULL) {
            $message = $common_logic->getMessage($res,$type);
            $this->msg = $message['res'];
            $this->type = $message['type'];
        }
        if (isset($_POST['login'])) {
            $id = I('post.id');
            $pwd = I('post.pwd');
            $user_model = M('User');
            $row = $user_model->where("number = '$id'")->select();
            if (count($row) == 0){
                $this->msg = "用户不存在!";
                $this->type = "danger";
            }elseif ($row[0]['password'] != md5($pwd)){
                $this->msg = "密码错误!";
                $this->type = "danger";
            }else{
                $per = $row[0]['permission'];

                session("user", $id);
                session("per", $per);
                session("username",$user_logic->get_user_name($id));
                switch ($per){
                    case "1": $this->redirect('Student/my_course');break;
                    case "2": $this->redirect('Teacher/my_course');break;
                    case "3": $this->redirect('Administer/student_manage');break;
                    default: {
                        $this->msg = "登录失败!";
                        $this->type = "danger";
                    }
                }
            }
        }

        $this->display('Common:Login');
    }

    public function logout(){//.....................................................................................登出
        session(null);
        $this->redirect('Common/login/');
    }

    public function find_pwd()//................................................................................找回密码
    {

        $this->msg = "";
        $sub = '找回密码';
        $prefix = C('URL_HEAD').'Common/pwd_reset/id/';
        $body = '点击一下链接,或复制链接到浏览器打开:<br>'.$prefix;

        $common_logic = D('Common','Logic');

        if(isset($_POST['send'])){
            $address = I('post.address');
            $user_model = M('User');
            $rows = $user_model->where("email = '$address'")
                ->select();
            $student_id = NULL;
            if(count($rows)>0){
                $student_id = $rows[0]['number'];
                $body = $body.$student_id;
                if($common_logic->sendEmail($sub,$address,$body)){
                    session('reset_ip',get_client_ip());
                    $this->msg = "发送成功!";
                    $this->type = "success";
                }
                else {
                    $this->msg = "发送失败!";
                    $this->type = "danger";
                }
            }else{
                $this->msg = "用户不存在!";
                $this->type = "danger";
            }
        }

        $this->display('Common:Password-Find');
    }

    public function pwd_reset($id)//.............................................................................重置密码
    {
        if (session('reset_ip')!= get_client_ip()){
            $this->ajaxReturn("error!you are not allowed to see this page!");
        }
        $this->msg = "";
        $user = D('User');
        if (isset($_POST['rset'])) {
            $new_pwd = I('post.new_pwd');
            $row['password'] = $new_pwd;
            $row['number'] = $id;
            if($user->create($row)){
                $user->save();
                session('reset_ip','null');
                $this->redirect('Common/login/res/reset-suc/type/suc');
            }else{
                $this->msg = "重置失败!";
                $this->type = "danger";
            }

        }
        $this->display('Common:Password-Reset');
    }
}