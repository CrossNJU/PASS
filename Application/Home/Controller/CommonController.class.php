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
        $validate_logic = D('Validate','Logic');
        $validate_logic->setSession();
        $this->display('Common:Login');
    }

    public function register()//.................................................................................学生注册
    {
        $validate_logic = D('Validate','Logic');
        $validate_logic->setSession();

        if (isset($_POST['register'])) {
            $user_model = D('User');

            $student_id = I('post.stu_id');
            $rows = $user_model->where("number = '$student_id'")->select();
            if(count($rows)>0){
                $validate_logic->sendMsg('用户已存在','warning',0);
            }else{
                $data['number'] = $student_id;
                $data['password'] = I('post.pwd');
                $data['phone'] = I('post.phone');
                $data['email'] = I('post.email');
                $data['name'] = I('post.name');
                $data['academy'] = I('post.aca');
                $data['speciality'] = I('post.spe');
                $data['grade'] = I('post.grade');
                $data['save_time'] = date("y-m-d h:i:s");
                $data['permission'] = 1;
                if($user_model->create($data)){
                    $user_model->add();
                    $validate_logic->sendMsg('注册成功','success');
                    $this->redirect('Common/login');
                }else {
                    $validate_logic->sendMsg('注册失败','danger',0);
                }
            }
        }
        $this->display('Common:Register-Student');
    }

    public function login()//................................................................登录
    {
        $validate_logic = D('Validate','Logic');
//        echo "before: ".session('changed')."\n";
        $validate_logic->setSession();
//        echo "after: ".session('changed')."\n";

        $user_logic = D('User','Logic');

        if (isset($_POST['login'])) {
            $id = I('post.id');
            $pwd = I('post.pwd');
            $user_model = M('User');
            $row = $user_model->where("number = '$id'")->select();
            if (count($row) == 0){
                $validate_logic->sendMsg('用户不存在','warning',0);
            }elseif ($row[0]['password'] != md5($pwd)){
                $validate_logic->sendMsg('密码错误','danger',0);
            }else{
                $per = $row[0]['permission'];

                session("user", $id);
                session("per", $per);
                session("username",$user_logic->get_user_name($id));
                $validate_logic->sendMsg('登录成功','success');
                switch ($per){
                    case "1": if(session('?forUrl')) $this->redirect(session('forUrl'));
                        else $this->redirect('Student/my_course');break;
                    case "2": $this->redirect('Teacher/my_course');break;
                    case "3": $this->redirect('Administer/student_manage');break;
                    default: {
                        $validate_logic->sendMsg('登录失败','danger',0);
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

        $validate_logic = D('Validate','Logic');
        $validate_logic->setSession();

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
                    $validate_logic->sendMsg('发送成功','success',0);
                }
                else {
                    $validate_logic->sendMsg('发送失败','danger',0);
                }
            }else{
                $validate_logic->sendMsg('用户不存在','warning',0);
            }
        }

        $this->display('Common:Password-Find');
    }

    public function pwd_reset($id)//.............................................................................重置密码
    {
        if (session('reset_ip')!= get_client_ip()){
            $this->redirect('Common/not_found');
        }
        $validate_logic = D('Validate','Logic');
        $validate_logic->setSession();

        $user = D('User');
        if (isset($_POST['rset'])) {
            $new_pwd = I('post.new_pwd');
            $row['password'] = $new_pwd;
            $row['number'] = $id;
            if($user->create($row)){
                $user->save();
                session('reset_ip','null');
                $validate_logic->sendMsg('重置成功','success');
                $this->redirect('Common/login');
            }else{
                $validate_logic->sendMsg('重置失败','danger',0);
            }

        }
        $this->display('Common:Password-Reset');
    }

    public function _empty(){
        $this->display('Common:not-found');
    }

    public function feedback($feedback){

        $validate_logic = D('Validate','Logic');
        if(!session('?user')) $this->redirect('Common/login');
        $validate_logic->setSession();

        $user_model = M('User');
        $feedback_model = M('Feedback');
        $number = session('user');
        $user = $user_model->where("number = '$number'")->select()[0];
        $data['number'] = $number;
        $data['name'] = $user['name'];
        $data['permission'] = $user['permission'];
        $data['add_time'] = date("y-m-d");
        $data['content'] = $feedback;
        if($feedback_model->create($data)){
            $feedback_model->add();
            $this->ajaxReturn(1);
        }
        else $this->ajaxReturn(0);
    }
}